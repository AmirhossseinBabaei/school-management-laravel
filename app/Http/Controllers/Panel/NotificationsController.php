<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CreateNotificationsRequest;
use App\Repositories\AttendancesRepository;
use App\Repositories\NotificationsFailedRepository;
use App\Repositories\NotificationsRepository;
use App\Repositories\RolesRepository;
use App\Repositories\SchoolsRepository;
use App\Repositories\StudentsRepository;
use App\Repositories\UsersRepository;
use App\Services\JalaliDateService;
use App\Services\NotificationContextService;
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

    public function __construct(
        JalaliDateService       $jalaliDateService,
        NotificationsRepository $notificationsRepository,
        RolesRepository         $rolesRepository,
        UsersRepository         $usersRepository,
        SchoolsRepository       $schoolsRepository,
        StudentsRepository      $studentsRepository,
        AttendancesRepository   $attendancesRepository,
        NotificationsFailedRepository $notificationsFailedRepository
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
        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'roles' => $this->rolesRepository->all(),
            'schools' => $this->schoolsRepository->all(),
            'students' => $this->studentsRepository->all(),
        ];

        return view('dashboard.notifications.create', compact('data'));
    }

    public function store(CreateNotificationsRequest $request)
    {
        $requested = $request->validated();

        $chain = app('chain.notification');

        $getPhones = $chain->handle($requested['audience_data'], null);

        if ($requested['audience_data'] == 'student') {
            $getPhones = $chain->handle($requested['audience_data'], $requested['student_id']);
        }

        $notificationContext = new NotificationContextService(
            new SmsKavehNegarStrategy()
        );

        $notificationResult = $notificationContext->sendNotification($requested['message'], $getPhones);

        if (500 === $notificationResult[0]['status']) {
            $requested['status'] = 'exception';
        } else {
            $requested['status'] = 'send';
        }

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
