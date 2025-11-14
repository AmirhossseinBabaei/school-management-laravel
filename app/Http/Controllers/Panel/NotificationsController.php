<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CreateNotificationsRequest;
use App\Repositories\AttendancesRepository;
use App\Repositories\ClassRoomRepository;
use App\Repositories\NotificationsFailedRepository;
use App\Repositories\NotificationsRepository;
use App\Repositories\RolesRepository;
use App\Repositories\SchoolsRepository;
use App\Repositories\StudentsRepository;
use App\Repositories\StudyBasesRepository;
use App\Repositories\UsersRepository;
use App\Services\JalaliDateService;
use App\Services\MessageTemplateService;
use App\Services\NotificationContextService;
use App\Strategies\SmsDotIrStrategy;
use App\Strategies\SmsKavehNegarStrategy;
use Illuminate\View\View;

class NotificationsController extends Controller
{
    protected JalaliDateService $jalaliDateService;
    protected NotificationsRepository $notificationsRepository;
    protected RolesRepository $rolesRepository;
    protected UsersRepository $usersRepository;
    protected SchoolsRepository $schoolsRepository;
    protected StudentsRepository $studentsRepository;
    protected AttendancesRepository $attendancesRepository;
    protected NotificationsFailedRepository $notificationsFailedRepository;
    protected MessageTemplateService $messageTemplateService;
    protected ClassRoomRepository $classRoomRepository;
    protected StudyBasesRepository $studyBasesRepository;

    public function __construct(
        JalaliDateService       $jalaliDateService,
        NotificationsRepository $notificationsRepository,
        RolesRepository         $rolesRepository,
        UsersRepository         $usersRepository,
        SchoolsRepository       $schoolsRepository,
        StudentsRepository      $studentsRepository,
        AttendancesRepository   $attendancesRepository,
        NotificationsFailedRepository $notificationsFailedRepository,
        MessageTemplateService  $messageTemplateService,
        ClassRoomRepository     $classRoomRepository,
        StudyBasesRepository    $studyBasesRepository
    )
    {
        $this->jalaliDateService = $jalaliDateService;
        $this->notificationsRepository = $notificationsRepository;
        $this->rolesRepository = $rolesRepository;
        $this->usersRepository = $usersRepository;
        $this->schoolsRepository = $schoolsRepository;
        $this->studentsRepository = $studentsRepository;
        $this->attendancesRepository = $attendancesRepository;
        $this->notificationsFailedRepository = $notificationsFailedRepository;
        $this->messageTemplateService = $messageTemplateService;
        $this->classRoomRepository = $classRoomRepository;
        $this->studyBasesRepository = $studyBasesRepository;
    }

    public function index()
    {
        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'notifications' => $this->notificationsRepository->getAllByPaginate()
        ];

        return view('dashboard.notifications.all', compact('data'));
    }

    public function create()
    {
        $schoolId = auth()->user()->school_id;

        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'roles' => $this->rolesRepository->all(),
            'schools' => $this->schoolsRepository->all(),
            'students' => $schoolId ? $this->studentsRepository->getStudentsBySchool($schoolId) : $this->studentsRepository->all(),
            'classes' => $schoolId ? $this->classRoomRepository->getClassesBySchoolId($schoolId) : $this->classRoomRepository->all(),
            'studyBases' => $schoolId ? $this->studyBasesRepository->all() : '[]',
            'smartFields' => $this->messageTemplateService->getAvailableSmartFields(),
        ];

        return view('dashboard.notifications.create', compact('data'));
    }

    public function store(CreateNotificationsRequest $request)
    {
        $requested = $request->validated();

        $chain = app('chain.notification');

        // Determine the ID parameter based on audience type
        $id = null;
        $audienceData = $requested['audience_data'];

        switch ($audienceData) {
            case 'student':
            case 'parent':
                $id = $requested['student_id'] ?? null;
                break;
            case 'multipleStudents':
                $id = $requested['student_ids'] ?? [];
                break;
            case 'class':
                $id = $requested['class_id'] ?? null;
                break;
            case 'studyBase':
                $id = $requested['study_base_id'] ?? null;
                break;
            case 'allSchoolStudents':
            case 'allSchool':
            case 'absentStudents':
                $id = $requested['school_id'] ?? auth()->user()->school_id;
                break;
            case 'lowGradeStudents':
                $id = $requested['min_grade'] ?? 10;
                break;
            default:
                $id = null;
                break;
        }

//        dd($requested['audience_data']);

        $getPhones = $chain->handle($audienceData, $id);
        dd($getPhones);

        if (empty($getPhones)) {
            return redirect()->route('dashboard.notifications.create')
                ->with('error', 'هیچ گیرنده‌ای یافت نشد.')
                ->withInput();
        }

        dd($getPhones);

        $notificationContext = new NotificationContextService(
            new SmsDotIrStrategy()
        );

        // Get school for smart field replacement
        $school = null;
        if (auth()->user()->school_id) {
            $school = $this->schoolsRepository->getOneById(auth()->user()->school_id);
        }

        // Send notifications with smart field replacement
        $results = [];
        $baseMessage = $requested['message'];

        foreach ($getPhones as $phone) {
            // Find student by phone for smart field replacement
            $student = null;
            if (in_array($audienceData, ['student', 'parent', 'multipleStudents', 'class', 'studyBase', 'allSchoolStudents', 'absentStudents'])) {
                $user = \App\Models\User::where('phone', $phone)->first();
                if ($user) {
                    $student = \App\Models\Student::where('user_id', $user->id)->first();
                }
            }

            // Replace smart fields for each recipient
            $personalizedMessage = $this->messageTemplateService->replaceSmartFields($baseMessage, $student, $school);

            $result = $notificationContext->sendNotification($personalizedMessage, [$phone], $personalizedMessage);
            $results[] = $result[0] ?? ['status' => 500];
        }

        // Check if any notification failed
        $hasError = false;
        foreach ($results as $result) {
            if (500 === ($result['status'] ?? 500)) {
                $hasError = true;
                break;
            }
        }

        $requested['status'] = $hasError ? 'exception' : 'send';
        $requested['channels'] = json_encode($requested['channels']);

        $notificationStored = $this->notificationsRepository->store($requested);

        if (false == $notificationStored) {
            return redirect()->route('dashboard.notifications.index')
                ->with('error', __('messages.notifications.createNotificationsError'));
        }

        return redirect()->route('dashboard.notifications.index')
            ->with('success', __('messages.notifications.createNotificationsSuccess'));
    }

    public function allNotificationFailed(): View
    {
        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'notifications' => $this->notificationsFailedRepository->getAllByPaginate()
        ];

        return view('dashboard.notifications.allFailed', compact('data'));
    }

    public function showNotificationFailed($id)
    {
        $notificationFailed = $this->notificationsFailedRepository->getOneById($id);

        if (null === $notificationFailed) {
            return redirect()->route('dashboard.notifications.allFailed')
                ->with('error', __('messages.lessons.findNotificationsError'));
        }

        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'notification' => $notificationFailed,
        ];

        return view('dashboard.notifications.showFailed', compact('data'));
    }
}
