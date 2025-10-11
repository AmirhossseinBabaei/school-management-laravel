<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAttendanceRequest;
use App\Repositories\AttendancesRepository;
use App\Repositories\ClassRoomRepository;
use App\Repositories\LessonsRepository;
use App\Repositories\StudentsRepository;
use App\Repositories\UsersRepository;
use App\Services\JalaliDateService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    protected StudentsRepository $studentsRepository;
    protected ClassRoomRepository $classRoomRepository;
    protected LessonsRepository $lessonsRepository;
    protected UsersRepository $usersRepository;
    protected AttendancesRepository $attendancesRepository;

    protected JalaliDateService $jalaliDateService;

    public function __construct(
        StudentsRepository    $studentsRepository,
        ClassRoomRepository   $classRoomRepository,
        JalaliDateService     $jalaliDateService,
        LessonsRepository     $lessonsRepository,
        UsersRepository       $usersRepository,
        AttendancesRepository $attendancesRepository
    )
    {
        $this->studentsRepository = $studentsRepository;
        $this->classRoomRepository = $classRoomRepository;
        $this->lessonsRepository = $lessonsRepository;
        $this->usersRepository = $usersRepository;
        $this->jalaliDateService = $jalaliDateService;
        $this->attendancesRepository = $attendancesRepository;
    }

    public function index()
    {
        $schoolId = Auth::user()->school_id;

        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'classes' => $this->classRoomRepository->getClassesBySchoolId($schoolId),
            'lessons' => $this->lessonsRepository->all(),
            'teachers' => $this->usersRepository->getTeachersBySchoolId($schoolId)
        ];
        return view('dashboard.attendances.all', compact('data'));
    }

    public function getStudents($classId): JsonResponse
    {
        $students = $this->studentsRepository
            ->setModel()
            ::where('class_id', $classId)
            ->with('user')
            ->get();

        $users = [];

        foreach ($students as $student) {
            $user['first_name'] = $student->user->first_name;
            $user['last_name'] = $student->user->last_name;
            $user['student_id'] = $student->id;
            $user['full_name'] = $student->user->first_name . ' ' . $student->user->last_name;

            $users[] = $user;
        }

        usort($users, function($a, $b) {
            return $this->comparePersianNames($a['full_name'], $b['full_name']);
        });

        return response()->json(
            [
                'students' => $users,
                'status' => 1
            ]
        );
    }

    private function comparePersianNames($name1, $name2): int
    {
        $type1 = $this->detectNameType($name1);
        $type2 = $this->detectNameType($name2);

        if ($type1 === 'persian' && $type2 === 'english') {
            return -1;
        }
        if ($type1 === 'english' && $type2 === 'persian') {
            return 1;
        }

        if ($type1 === 'mixed_persian_english' && $type2 === 'persian') {
            return 1;
        }
        if ($type1 === 'persian' && $type2 === 'mixed_persian_english') {
            return -1;
        }

        if ($type1 === 'mixed_english_persian' && $type2 === 'persian') {
            return 1;
        }
        if ($type1 === 'persian' && $type2 === 'mixed_english_persian') {
            return -1;
        }

        if ($type1 === 'mixed_persian_english' && $type2 === 'mixed_english_persian') {
            return -1;
        }
        if ($type1 === 'mixed_english_persian' && $type2 === 'mixed_persian_english') {
            return 1;
        }

        return strcoll($name1, $name2);
    }

    private function detectNameType($name): string
    {
        $persianChars = '/[\x{0600}-\x{06FF}]/u';
        $englishChars = '/[a-zA-Z]/';

        $hasPersian = preg_match($persianChars, $name);
        $hasEnglish = preg_match($englishChars, $name);

        if ($hasPersian && !$hasEnglish) {
            return 'persian';
        }
        if (!$hasPersian && $hasEnglish) {
            return 'english';
        }
        if ($hasPersian && $hasEnglish) {
            $firstChar = mb_substr($name, 0, 1);
            if (preg_match($persianChars, $firstChar)) {
                return 'mixed_persian_english';
            } else {
                return 'mixed_english_persian';
            }
        }

        return 'other';
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'lesson_id' => 'required|exists:lessons,id',
            'students' => 'required|array|min:1',
            'students.*.student_id' => 'required|exists:students,id',
            'students.*.status' => 'required|in:present,absent,late',
            'students.*.description' => 'nullable|string|max:500'
        ]);

        $requested = $request->toArray();

        $data = [];

        foreach ($requested['students'] as $student) {

            $studentsAttendance = [
                'student_id' => $student['student_id'],
                'school_id' => Auth::user()->school_id,
                'class_id' => $requested['class_id'],
                'lesson_id' => $requested['lesson_id'],
                'attended_at' => Carbon::now(),
                'status' => $student['status'],
                'description' => $student['description'] ?? null,
                'attendance_by_user_id' => Auth::user()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $data[] = $studentsAttendance;
        }

        $response = $this->attendancesRepository->setModel()::insert($data);

        if (true == $response) {
            return response()->json(['status' => 1]);
        }

        return response()->json(['status' => 0]);
    }
}
