<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Repositories\ClassRoomRepository;
use App\Repositories\LessonsRepository;
use App\Repositories\StudentsRepository;
use App\Repositories\UsersRepository;
use App\Services\JalaliDateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    protected StudentsRepository $studentsRepository;
    protected ClassRoomRepository $classRoomRepository;
    protected LessonsRepository $lessonsRepository;
    protected UsersRepository $usersRepository;
    protected JalaliDateService $jalaliDateService;

    public function __construct(
        StudentsRepository  $studentsRepository,
        ClassRoomRepository $classRoomRepository,
        JalaliDateService   $jalaliDateService,
        LessonsRepository   $lessonsRepository,
        UsersRepository     $usersRepository
    )
    {
        $this->studentsRepository = $studentsRepository;
        $this->classRoomRepository = $classRoomRepository;
        $this->lessonsRepository = $lessonsRepository;
        $this->usersRepository = $usersRepository;
        $this->jalaliDateService = $jalaliDateService;
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

    public function getStudents(Request $request): JsonResponse
    {
        return response()->json(
            [
                'students' => $this->studentsRepository
                    ->where('class_id', $request['class_id'])->get(),
                'status' => 1
            ]
        );
    }
}
