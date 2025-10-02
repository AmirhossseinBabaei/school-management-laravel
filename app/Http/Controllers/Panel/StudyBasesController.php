<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CreateStudyBaseRequest;
use App\Repositories\StudyBasesRepository;
use App\Services\JalaliDateService;
use Illuminate\Http\Request;

class StudyBasesController extends Controller
{
    protected StudyBasesRepository $studyBasesRepository;
    protected JalaliDateService $jalaliDateService;

    public function __construct(
        StudyBasesRepository $studyBasesRepository,
        JalaliDateService    $jalaliDateService
    )
    {
        $this->studyBasesRepository = $studyBasesRepository;
        $this->jalaliDateService = $jalaliDateService;
    }

    public function index()
    {
        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'studyBases' => $this->studyBasesRepository->getAllByPaginate()
        ];

        return view('dashboard.studyBases.all', compact('data'));
    }

    public function create()
    {
        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
        ];

        return view('dashboard.studyBases.create', compact('data'));
    }

    public function store(CreateStudyBaseRequest $request)
    {
        $requested = $request->validated();

        $studyBase = $this->studyBasesRepository->store($requested);

        if (false === $studyBase) {
            return redirect()->route('dashboard.studyBases.index')->with('error', __('messages.studyBases.createStudyBaseError'));
        }

        return redirect()->route('dashboard.studyBases.index')->with('success', __('messages.studyBases.createStudyBaseSuccess'));
    }

    public function show(string $id)
    {
        $studyBase = $this->studyBasesRepository->getOneById($id);

        if (null === $studyBase) {
            return redirect()->route('dashboard.studyBases.index')->with('error', __('messages.studyBases.findStudyBaseError'));
        }

        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'studyBase' => $studyBase
        ];

        return view('dashboard.studyBases.show', compact('data'));
    }

    public function edit(string $id)
    {
        $studyBase = $this->studyBasesRepository->getOneById($id);

        if (null === $studyBase) {
            return redirect()->route('dashboard.studyBases.index')->with('error', __('messages.studyBases.findStudyBaseError'));
        }

        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'studyBase' => $studyBase
        ];

        return view('dashboard.studyBases.edit', compact('data'));
    }

    public function update(CreateStudyBaseRequest $request, string $id)
    {
        $requested = $request->validated();

        $studyBase = $this->studyBasesRepository->getOneById($id);

        if (null === $studyBase) {
            return redirect()->route('dashboard.studyBases.index')->with('success', __('messages.studyBases.findStudyBaseError'));
        }

        $studyBaseUpdate = $this->studyBasesRepository->update($id, $requested);

        if (false == $studyBaseUpdate) {
            return redirect()->route('dashboard.studyBases.index')->with('error', __('messages.studyBases.updateStudyBaseError'));
        }
        return redirect()->route('dashboard.studyBases.index')->with('success', __('messages.studyBases.updateStudyBaseSuccess'));
    }

    public function destroy(string $id)
    {
        $studyBase = $this->studyBasesRepository->getOneById($id);

        if (null === $studyBase) {
            return redirect()->route('dashboard.studyBases.index')->with('error', __('messages.studyBases.findStudyBaseError'));
        }

        $studyBaseDeleted = $this->studyBasesRepository->destroy($id);

        if (false == $studyBaseDeleted){
            return response()->json(['status' => 0, __('messages.studyBases.deleteStudyBaseError')]);
        }

        return response()->json(['status' => 1, __('messages.studyBases.deleteStudyBaseSuccess')]);
    }
}
