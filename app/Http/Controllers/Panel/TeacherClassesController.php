<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CreateTeacherClassRequest;
use App\Http\Requests\Panel\CreateUserRequest;
use App\Http\Requests\Panel\UpdateUserRequest;
use App\Repositories\TeacherClassesRepository;
use App\Services\JalaliDateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class TeacherClassesController extends Controller
{
    protected TeacherClassesRepository $teacherClassesRepository;
    protected JalaliDateService $jalaliDateService;

    public function __construct(
        TeacherClassesRepository $teacherClassesRepository,
        JalaliDateService        $jalaliDateService
    )
    {
        $this->teacherClassesRepository = $teacherClassesRepository;
        $this->jalaliDateService = $jalaliDateService;
    }

    public function index()
    {
        $chain = app('chain.indexMethodControllersData');
        $data = $chain->handle('TeacherClassesData');

        return view('dashboard.teacherClasses.all', compact('data'));
    }

    public function show($id)
    {
        $teacherClass = $this->teacherClassesRepository->getOneById($id);

//        $this->authorize('view', $teacherClass);

        if (null === $teacherClass) {
            return redirect()->route('dashboard.teacherClasses.index')
                ->with('error', __('messages.teacherClasses.findTeacherClassesError'));
        }

        $data = [
            'teacherClass' => $teacherClass,
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd')
        ];

        return view('dashboard.teacherClasses.show', compact('data'));
    }

    public function create()
    {
        $chain = app('chain.createMethodControllersData');
        $data = $chain->handle('TeacherClassesData');

        return view('dashboard.teacherClasses.create', compact('data'));
    }

    public function store(CreateTeacherClassRequest $request)
    {
        $requested = $request->validated();

        $teacherClass = $this->teacherClassesRepository->store($requested);

        if (false == $teacherClass) {
            return redirect()->route('dashboard.teacherClasses.index')->with('error', __('messages.teacherClasses.createTeacherClassesError'));
        }

        return redirect()->route('dashboard.teacherClasses.index')->with('success', __('messages.teacherClasses.createTeacherClassesSuccess'));
    }

    public function edit($id): View
    {
        $teacherClass = $this->teacherClassesRepository->getOneById($id);

        if (null === $teacherClass) {
            return redirect()->route('dashboard.teacherClasses.index')->with('error', __('messages.teacherClasses.findTeacherClassesError'));
        }

        $chain = app('chain.createMethodControllersData');
        $data = $chain->handle('TeacherClassesData');

        $data['teacherClass'] = $teacherClass;

        return view('dashboard.teacherClasses.edit', compact('data'));
    }

    public function update($id, CreateTeacherClassRequest $request)
    {
        $requested = $request->validated();

        $teacherClass = $this->teacherClassesRepository->getOneById($id);

//        $this->authorize('update', $teacherClass);

        if (null === $teacherClass) {
            return redirect()->route('dashboard.teacherClasses.index')->with('error', __('messages.teacherClasses.findTeacherClassesError'));
        }

        $teacherClassUpdate = $this->teacherClassesRepository->update($id, $requested);

        if (false == $teacherClassUpdate) {
            return redirect()->route('dashboard.teacherClasses.index')->with('error', __('messages.teacherClasses.updateTeacherClassesError'));
        }

        return redirect()->route('dashboard.teacherClasses.index')->with('success', __('messages.teacherClasses.updateTeacherClassesSuccess'));
    }

    public function destroy($id)
    {
        $teacherClass = $this->teacherClassesRepository->getOneById($id);

//        $this->authorize('delete', $teacherClass);

        if (null === $teacherClass) {
            return redirect()->route('dashboard.teacherClass.index')
                ->with('error', __('messages.teacherClass.findTeacherClassError'));
        }

        $teacherClassDelete = $this->teacherClassesRepository->destroy($id);

        if (true == $teacherClassDelete) {
            return response()->json(['status' => 1, 'message' => __('messages.teacherClasses.deleteTeacherClassesSuccess')]);
        }

        return response()->json(['status' => 0, 'message' => __('messages.teacherClasses.deleteTeacherClassesError')]);
    }
}
