<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAttendanceRequest;
use App\Http\Requests\Panel\GetAttendanceStudentsDataRequest;
use App\Repositories\AttendancesRepository;
use App\Repositories\ClassRoomRepository;
use App\Repositories\LessonsRepository;
use App\Repositories\StudentsRepository;
use App\Repositories\UsersRepository;
use App\Services\JalaliDateService;
use App\Services\JalaliDateServiceStatic;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendancesController extends Controller
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
        $chain = app('chain.indexMethodControllersData');
        $data = $chain->handle('attendancesData');

        return view('dashboard.attendances.all', compact('data'));
    }

    public function getStudents($classId): JsonResponse
    {
//        $this->authorize('getStudentsByClassId', $classId);

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

        usort($users, function ($a, $b) {
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

    public function store(CreateAttendanceRequest $request)
    {
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

    public function getReportPageData()
    {
        $chain = app('chain.indexMethodControllersData');
        $data = $chain->handle('attendancesData');

        return view('dashboard.attendances.reports', compact('data'));
    }

    public function getReportChartsPageData()
    {
        return view('dashboard.attendances.reports');
    }

    public function show () {
        return $this->searchByNationalCode();
    }

    public function getAttendanceStudentsData(Request $request)
    {
        $classId = $request['class_id'] == 'all' ? null : $request['class_id'];
        $lessonId = $request['lesson_id'] == 'all' ? null : $request['lesson_id'];
        $status = $request['status'] == 'all' ? null : $request['status'];

        $fromDate = JalaliDateServiceStatic::toGregorian($request['from_date']);
        $toDate = JalaliDateServiceStatic::toGregorian($request['to_date']);

//        $classId = 31;
//        $lessonId = 27;
//        $status = 'absent';
//        $fromDate = '2025-09-09';
//        $toDate = '2026-09-09';

        $students = $this->attendancesRepository
            ->setModel()
            ::with('student.user', 'classRoom', 'lesson')
            ->where('school_id', Auth::user()->school_id)
            ->when($classId, fn($q) => $q->where('class_id', $classId))
            ->when($lessonId, fn($q) => $q->where('lesson_id', $lessonId))
            ->when($status, fn($q) => $q->where('status', $status))
            ->where('attended_at', '>=', $fromDate)
            ->where('attended_at', '<=', $toDate)
            ->get();

        return response()->json(['data' => $students]);
    }

    /**
     * نمایش صفحه جستجو با کد ملی
     */
    public function searchByNationalCode()
    {
        $chain = app('chain.indexMethodControllersData');
        $data = $chain->handle('attendancesData');

        return view('dashboard.attendances.search-by-national-code', compact('data'));
    }

    /**
     * دریافت اطلاعات دانش‌آموز و غیبت‌هایش بر اساس کد ملی
     */
    public function getStudentAbsences(Request $request): JsonResponse
    {
        $request->validate([
            'national_code' => 'required|string|size:10'
        ]);

        $nationalCode = $request->input('national_code');

        // پیدا کردن دانش‌آموز بر اساس کد ملی
        $user = $this->usersRepository
            ->setModel()
            ::where('national_code', $nationalCode)
            ->where('school_id', Auth::user()->school_id)
            ->first();

        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'دانش‌آموزی با این کد ملی یافت نشد.'
            ], 404);
        }

        // پیدا کردن رکورد دانش‌آموز
        $student = $this->studentsRepository
            ->setModel()
            ::where('user_id', $user->id)
            ->where('school_id', Auth::user()->school_id)
            ->with(['user', 'classRoom'])
            ->first();

        if (!$student) {
            return response()->json([
                'status' => 0,
                'message' => 'رکورد دانش‌آموزی یافت نشد.'
            ], 404);
        }

        // دریافت تمام غیبت‌ها
        $absences = $this->attendancesRepository
            ->setModel()
            ::where('student_id', $student->id)
            ->where('status', 'absent')
            ->where('school_id', Auth::user()->school_id)
            ->with(['classRoom', 'lesson'])
            ->orderBy('attended_at', 'desc')
            ->get()
            ->map(function ($attendance) {
                return [
                    'id' => $attendance->id,
                    'date' => JalaliDateServiceStatic::toJalali($attendance->attended_at, 'yyyy/MM/dd'),
                    'date_time' => JalaliDateServiceStatic::toJalali($attendance->attended_at, 'yyyy/MM/dd HH:mm'),
                    'class_name' => $attendance->classRoom->name ?? '-',
                    'lesson_name' => $attendance->lesson->name ?? '-',
                    'status' => $attendance->status,
                    'description' => $attendance->description,
                    'attended_at' => $attendance->attended_at
                ];
            });

        return response()->json([
            'status' => 1,
            'student' => [
                'id' => $student->id,
                'first_name' => $student->user->first_name,
                'last_name' => $student->user->last_name,
                'full_name' => $student->user->first_name . ' ' . $student->user->last_name,
                'national_code' => $student->user->national_code,
                'class_name' => $student->classRoom->name ?? '-'
            ],
            'absences' => $absences,
            'total_absences' => $absences->count()
        ]);
    }

    /**
     * به‌روزرسانی وضعیت حضور و غیاب
     */
    public function updateAttendanceStatus(Request $request): JsonResponse
    {
        $request->validate([
            'attendance_id' => 'required|exists:attendances,id',
            'status' => 'required|in:present,absent,late',
            'description' => 'nullable|string|max:500'
        ]);

        $attendance = $this->attendancesRepository
            ->setModel()
            ::where('id', $request->input('attendance_id'))
            ->where('school_id', Auth::user()->school_id)
            ->first();

        if (!$attendance) {
            return response()->json([
                'status' => 0,
                'message' => 'رکورد حضور و غیاب یافت نشد.'
            ], 404);
        }

        $attendance->update([
            'status' => $request->input('status'),
            'description' => $request->input('description'),
            'attendance_by_user_id' => Auth::user()->id
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'وضعیت با موفقیت به‌روزرسانی شد.',
            'attendance' => [
                'id' => $attendance->id,
                'status' => $attendance->status,
                'description' => $attendance->description,
                'date' => JalaliDateServiceStatic::toJalali($attendance->attended_at, 'yyyy/MM/dd')
            ]
        ]);
    }
}
