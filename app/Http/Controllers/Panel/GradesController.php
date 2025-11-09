<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGradeRequest;
use App\Repositories\ClassRoomRepository;
use App\Repositories\GradesRepository;
use App\Repositories\LessonsRepository;
use App\Repositories\TermsRepository;
use App\Repositories\TeacherClassesRepository;
use App\Repositories\UsersRepository;
use App\Repositories\StudentsRepository;
use App\Services\JalaliDateServiceStatic;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GradesController extends Controller
{
    protected GradesRepository $gradesRepository;
    protected ClassRoomRepository $classRoomRepository;
    protected LessonsRepository $lessonsRepository;
    protected TeacherClassesRepository $teacherClassesRepository;
    protected UsersRepository $usersRepository;
    protected TermsRepository $termsRepository;
    protected StudentsRepository $studentsRepository;

    public function __construct(
        GradesRepository $gradesRepository,
        ClassRoomRepository $classRoomRepository,
        LessonsRepository $lessonsRepository,
        TeacherClassesRepository $teacherClassesRepository,
        UsersRepository $usersRepository,
        TermsRepository $termsRepository,
        StudentsRepository $studentsRepository
    ) {
        $this->gradesRepository = $gradesRepository;
        $this->classRoomRepository = $classRoomRepository;
        $this->lessonsRepository = $lessonsRepository;
        $this->teacherClassesRepository = $teacherClassesRepository;
        $this->usersRepository = $usersRepository;
        $this->termsRepository = $termsRepository;
        $this->studentsRepository = $studentsRepository;
    }

    public function index()
    {
        $nowDate = (new JalaliDateServiceStatic())->now('yyyy/MM/dd');

        $data = [
            'nowDate' => (new JalaliDateServiceStatic())->now('yyyy/MM/dd')
        ];

        if (Auth::user()->hasRole('teacher')) {
            $classes = $this->teacherClassesRepository
                ->setModel()::with('classRoom')
                ->where('teacher_id', Auth::id())
                ->get();

            $lessons = $this->teacherClassesRepository
                ->setModel()::with('lesson')
                ->where('teacher_id', Auth::id())
                ->get();

            $teacher = $this->usersRepository->getOneById(Auth::id());
            $terms = $this->termsRepository
                ->setModel()
                ::where('school_id', Auth::user()->school_id)->get();

            $data = compact('data', 'classes', 'lessons', 'teacher', 'terms');
        } else {
            $nowDate = (new JalaliDateServiceStatic())->now('yyyy/MM/dd');
            $classes = $this->classRoomRepository->getClassesBySchoolId(Auth::user()->school_id);
            $lessons = $this->lessonsRepository->all();
            $teachers = $this->usersRepository->getTeachersBySchoolId(Auth::user()->school_id);
            $terms = $this->termsRepository->setModel()
                ::where('school_id', Auth::user()->school_id)->get();;
            $data = compact('nowDate', 'classes', 'lessons', 'teachers', 'terms');
        }

        return view('dashboard.grades.all', compact('data'));
    }

    public function store(CreateGradeRequest $request): JsonResponse
    {
        $requested = $request->toArray();

        $schoolId = Auth::user()->school_id;
        $classId = (int)$requested['class_id'];
        $lessonId = (int)$requested['lesson_id'];
        $termId = (int)$requested['term_id'];

        $now = Carbon::now()->format('Y-m-d H:i:s');
        $bulk = [];
        foreach ($requested['students'] as $student) {
            $bulk[] = [
                'student_id' => (int)$student['student_id'],
                'teacher_id' => Auth::id(),
                'school_id' => $schoolId,
                'class_id' => $classId,
                'lesson_id' => $lessonId,
                'term_id' => $termId,
                'score' => $student['score'],
                'description' => $student['description'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::transaction(function () use ($schoolId, $classId, $lessonId, $termId, $bulk) {
            $this->gradesRepository->connection()
                ->where('school_id', $schoolId)
                ->where('class_id', $classId)
                ->where('lesson_id', $lessonId)
                ->where('term_id', $termId)
                ->delete();

            $this->gradesRepository->setModel()::insert($bulk);
        });

        return response()->json(['status' => 1]);
    }

    public function getGradeStudentsData(Request $request): JsonResponse
    {
        $classId = (int)$request->input('class_id');
        $lessonId = (int)$request->input('lesson_id');
        $termId = (int)$request->input('term_id');
        $schoolId = Auth::user()->school_id;

        $students = $this->studentsRepository
            ->setModel()
            ::where('class_id', $classId)
            ->with('user')
            ->get();

        $grades = $this->gradesRepository
            ->setModel()
            ::where('school_id', $schoolId)
            ->where('class_id', $classId)
            ->where('lesson_id', $lessonId)
            ->where('term_id', $termId)
            ->get()
            ->keyBy('student_id');

        $items = [];
        foreach ($students as $student) {
            $g = $grades->get($student->id);
            $items[] = [
                'student_id' => $student->id,
                'first_name' => $student->user->first_name,
                'last_name' => $student->user->last_name,
                'score' => $g ? (float)$g->score : 0,
                'description' => $g ? (string)($g->description ?? '') : '',
            ];
        }

        return response()->json(['students' => $items, 'status' => 1]);
    }
}


