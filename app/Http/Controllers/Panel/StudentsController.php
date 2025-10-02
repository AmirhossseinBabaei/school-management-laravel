<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Repositories\ClassRoomRepository;
use App\Repositories\SchoolsRepository;
use App\Repositories\StudentsRepository;
use App\Repositories\StudyBasesRepository;
use App\Repositories\StudyFieldsRepository;
use App\Repositories\UsersRepository;
use App\Services\JalaliDateServiceStatic;
use App\Http\Requests\Panel\CreateStudentsRequest;
use Illuminate\View\View;

class StudentsController extends Controller
{
    protected StudentsRepository $studentsRepository;
    protected JalaliDateServiceStatic $jalaliDateService;
    protected SchoolsRepository $schoolsRepository;
    protected UsersRepository $usersRepository;
    protected StudyBasesRepository $studyBasesRepository;
    protected StudyFieldsRepository $studyFieldsRepository;
    protected ClassRoomRepository $classRoomRepository;

    public function __construct(
        StudentsRepository      $studentsRepository,
        JalaliDateServiceStatic $jalaliDateService,
        SchoolsRepository       $schoolsRepository,
        UsersRepository         $usersRepository,
        StudyBasesRepository    $studyBasesRepository,
        StudyFieldsRepository   $studyFieldsRepository,
        ClassRoomRepository     $classRoomRepository,
    )
    {
        $this->studentsRepository = $studentsRepository;
        $this->jalaliDateService = $jalaliDateService;
        $this->schoolsRepository = $schoolsRepository;
        $this->usersRepository = $usersRepository;
        $this->studyBasesRepository = $studyBasesRepository;
        $this->studyFieldsRepository = $studyFieldsRepository;
        $this->classRoomRepository = $classRoomRepository;
    }

    /**
     * Display a listing of students
     */
    public
    function index(): View
    {
        $chain = app('chain.indexMethodControllersData');
        $data = $chain->handle('studentsData');

        return view('dashboard.students.all', compact('data'));
    }

    /**
     * Show the form for creating a new student
     */
    public function create(): View
    {
        $chain = app('chain.createMethodControllersData');
        $data = $chain->handle('studentsData');

        return view('dashboard.students.create', compact('data'));
    }

    /**
     * Store a newly created student
     */
    public
    function store(CreateStudentsRequest $request)
    {
        $requested = $request->validated();

        $student = $this->studentsRepository->store($requested);

        if (false === $student) {
            return redirect()->route('dashboard.students.index')->with('error', __('messages.students.createStudentsError'));
        }

        return redirect()->route('dashboard.students.index')->with('success', __('messages.students.createStudentsSuccess'));
    }

    /**
     * Display the specified student
     */
    public
    function show($id): View
    {
        $student = $this->studentsRepository->getOneById($id);

        $this->authorize($student);

        if (null === $student) {
            return redirect()->route('dashboard.students.index')->with('error', __('messages.students.findStudentsError'));
        }

        $data = [
            'student' => $student,
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd')
        ];

        return view('dashboard.students.show', compact('data'));
    }

    /**
     * Show the form for editing the specified student
     */
    public
    function edit($id): View
    {
        $student = $this->studentsRepository->getOneById($id);

        $this->authorize($student);

        if (null === $student) {
            return redirect()->route('dashboard.students.index')->with('error', __('messages.students.findStudentsError'));
        }

        $chain = app('chain.createMethodControllersData');
        $data = $chain->handle('studentsData');

        $data['student'] = $student;

        return view('dashboard.students.edit', compact('data'));
    }

    /**
     * Update the specified student
     */
    public
    function update($id, CreateStudentsRequest $request)
    {
        $requested = $request->validated();

        $student = $this->studentsRepository->getOneById($id);

        $this->authorize($student);

        if (null === $student) {
            return redirect()->route('dashboard.students.index')->with('error', __('messages.students.findStudentsError'));
        }

        $updateStudent = $this->studentsRepository->update($id, $requested);

        if (false == $updateStudent) {
            return redirect()->route('dashboard.students.index')->with('error', __('messages.students.updateStudentsError'));
        }

        return redirect()->route('dashboard.students.index')->with('success', __('messages.students.updateStudentsSuccess'));
    }

    /**
     * Remove the specified student
     */
    public
    function destroy($id)
    {
        $student = $this->studentsRepository->getOneById($id);

        $this->authorize($student);

        if (null === $student) {
            return redirect()->route('dashboard.students.index')->with('error', __('messages.students.findStudentsError'));
        }

        $studentDeleted = $this->studentsRepository->destroy($id);

        if (true == $studentDeleted) {
            return response()->json(['status' => 1, 'message' => __('messages.students.deleteStudentsSuccess')]);
        }

        return response()->json(['status' => 0, 'message' => __('messages.students.deleteStudentsError')]);
    }
}



