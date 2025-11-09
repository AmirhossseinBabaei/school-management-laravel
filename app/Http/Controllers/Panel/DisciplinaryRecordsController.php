<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDisciplinaryRecordRequest;
use App\Repositories\ClassRoomRepository;
use App\Repositories\DisciplinaryRecordsRepository;
use App\Repositories\LessonsRepository;
use App\Repositories\StudentsRepository;
use App\Repositories\UsersRepository;
use App\Services\JalaliDateServiceStatic;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisciplinaryRecordsController extends Controller
{
    protected DisciplinaryRecordsRepository $repository;
    protected UsersRepository $usersRepository;
    protected StudentsRepository $studentsRepository;
    protected LessonsRepository $lessonsRepository;
    protected ClassRoomRepository $classRoomRepository;

    public function __construct(
        DisciplinaryRecordsRepository $repository,
        UsersRepository $usersRepository,
        StudentsRepository $studentsRepository,
        LessonsRepository $lessonsRepository,
        ClassRoomRepository $classRoomRepository
    ) {
        $this->repository = $repository;
        $this->usersRepository = $usersRepository;
        $this->studentsRepository = $studentsRepository;
        $this->lessonsRepository = $lessonsRepository;
        $this->classRoomRepository = $classRoomRepository;
    }

    public function create()
    {
        $data = [
            'nowDate' =>(new JalaliDateServiceStatic())->now('yyyy/MM/dd')
        ];
        $lessons = $this->lessonsRepository->all();
        $students = $this->studentsRepository->setModel()::with('user')->where('school_id', Auth::user()->school_id)->get();
        $classes = $this->classRoomRepository->setModel()::where('school_id', Auth::user()->school_id)->get();

        return view('dashboard.disciplinaryRecords.create', compact('lessons', 'students', 'classes', 'data'));
    }

    public function store(CreateDisciplinaryRecordRequest $request)
    {
        $national = $request->input('national_code');
        $user = $this->usersRepository->setModel()::where('national_code', $national)
            ->where('school_id', Auth::user()->school_id)->first();

        if (!$user) {
            return response()->json(['status' => 0, 'message' => 'کاربر با این کدملی یافت نشد']);
        }

        $student = $this->studentsRepository->setModel()::where('user_id', $user->id)->first();
        if (!$student) {
            return response()->json(['status' => 0, 'message' => 'دانش‌آموز مربوطه یافت نشد']);
        }

        $data = [
            'student_id' => $student->id,
            'lesson_id' => $request->input('lesson_id') ?: null,
            'description' => $request->input('description') ?: null,
            'severity' => $request->input('severity'),
            'type' => $request->input('type'),
            'score' => $request->input('score') !== null ? (float)$request->input('score') : null,
            'record_date' => $request->input('record_date') ?: Carbon::now()->format('Y-m-d'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        $ok = $this->repository->setModel()::insert($data);

        if (1 == $ok)
        {
            return redirect()->back()->with('success', 'با موفقیت ثبت شد');
        }
        else {
            return redirect()->back()->with('error', 'مشکلی پیش آمد بعدا تلاش کنید یا با پشتیبانی تماس بگیرید');
        }
    }

    public function report()
    {
        $data = [
            'nowDate' => (new JalaliDateServiceStatic())->now('yyyy/MM/dd')
        ];
        return view('dashboard.disciplinaryRecords.report', compact('data'));
    }

    public function fetchReport(Request $request): JsonResponse
    {
        $request->validate([
            'national_code' => ['required','string']
        ]);

        $national = $request->input('national_code');

        $user = $this->usersRepository->setModel()::where('national_code', $national)
            ->first();

        if (!$user) {
            return response()->json(['status' => 0, 'message' => 'کاربر با این کدملی یافت نشد']);
        }

        if (Auth::user()->hasRole('student')) {
            if (!($request['national_code'] === Auth::user()->national_code)) {
                return response()->json(['status' => 0, 'message' => 'شماره تلفن با کدملی مطابقت ندارد']);
            }
        }

        $student = $this->studentsRepository->setModel()::with('classRoom')
            ->where('user_id', $user->id)
            ->where('school_id', Auth::user()->school_id)
            ->first();
        if (!$student) {
            return response()->json(['status' => 0, 'message' => 'دانش‌آموز مربوطه یافت نشد']);
        }

        $records = $this->repository->setModel()::with('lesson')
            ->where('student_id', $student->id)
            ->orderByDesc('record_date')
            ->get();

        // Build severity histogram (optional for UI)
        $counts = [];
        foreach ($records as $record) {
            $key = (string)$record->severity;
            $counts[$key] = ($counts[$key] ?? 0) + 1;
        }

        $positive = $records->where('type', 'positive')->values();
        $negative = $records->where('type', 'negative')->values();

        $summary = $this->buildSummary($records->count(), $negative->count(), $positive->count());

        return response()->json([
            'status' => 1,
            'student' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'class' => optional($student->classRoom)->name ?? optional($student->classRoom)->title,
                'student_id' => $student->id,
            ],
            'records' => $records->map(function ($record) {
                return [
                    'lesson' => $record->lesson->name ?? $record->lesson->title ?? null,
                    'description' => $record->description,
                    'severity' => $record->severity,
                    'type' => $record->type,
                    'score' => $record->score,
                    'record_date' => $record->record_date,
                ];
            }),
            'positive' => $positive->map(function ($record) {
                return [
                    'lesson' => $record->lesson->name ?? $record->lesson->title ?? null,
                    'description' => $record->description,
                    'severity' => $record->severity,
                    'type' => $record->type,
                    'score' => $record->score,
                    'record_date' => $record->record_date,
                ];
            }),
            'negative' => $negative->map(function ($record) {
                return [
                    'lesson' => $record->lesson->name ?? $record->lesson->title ?? null,
                    'description' => $record->description,
                    'severity' => $record->severity,
                    'type' => $record->type,
                    'score' => $record->score,
                    'record_date' => $record->record_date,
                ];
            }),
            'counts' => $counts,
            'summary' => $summary,
        ]);
    }

    private function buildSummary(int $total, int $negCount, int $posCount): string
    {
        if ($total === 0) {
            return 'دانش‌آموز منظم و بدون سابقه انضباطی است.';
        }

        if ($negCount >= 8) {
            return 'سوابق نشان می‌دهد دانش‌آموز نیاز به بررسی برای اخراج دارد.';
        }

        if ($negCount >= 5) {
            return 'دانش‌آموز در وضعیت بحرانی انضباطی قرار دارد.';
        }

        if ($negCount >= 3) {
            return 'دانش‌آموز بی‌نظم است و نیاز به پیگیری جدی دارد.';
        }

        if ($negCount >= 1 && $posCount < 2) {
            return 'دانش‌آموز مستعد بی‌نظمی است و باید زیر نظر باشد.';
        }

        return 'دانش‌آموز منظم و قابل اعتماد است.';
    }
}


