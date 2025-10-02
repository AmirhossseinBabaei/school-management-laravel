<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CreateStudyFieldRequest;
use App\Repositories\StudyBasesRepository;
use App\Repositories\StudyFieldsRepository;
use App\Services\JalaliDateService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudyFiledsController extends Controller
{
    protected JalaliDateService $jalaliDateService;
    protected StudyFieldsRepository $studyFieldsRepository;
    protected StudyBasesRepository $studyBasesRepository;

    public function __construct(
        JalaliDateService     $jalaliDateService,
        StudyFieldsRepository $studyFieldsRepository,
        StudyBasesRepository  $studyBasesRepository
    )
    {
        $this->jalaliDateService = $jalaliDateService;
        $this->studyFieldsRepository = $studyFieldsRepository;
        $this->studyBasesRepository = $studyBasesRepository;
    }

    public function index()
    {
        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'studyFields' => $this->studyFieldsRepository->getParentStudyFieldsByPaginate(),
            'parent' => NULL
        ];

        return view('dashboard.studyFields.all', compact('data'));
    }

    public function showChildrenOfStudyFields(string $id)
    {
        $studyField = $this->studyFieldsRepository->getOneById($id);

        if (null === $studyField) {
            return redirect()->route('dashboard.studyFields.index')->with('error', __(''));
        }

        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'studyFields' => $this->studyFieldsRepository->getChildrenStudyFields($id),
            'parent' => $studyField
        ];

        return view('dashboard.studyFields.all', compact('data'));
    }

    public function create(): View
    {
        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'studyBases' => $this->studyBasesRepository->all(),
            'studyFields' => $this->studyFieldsRepository->all()
        ];

        return view('dashboard.studyFields.create', compact('data'));
    }

    public function store(CreateStudyFieldRequest $request)
    {
        $requested = $request->validated();

        $studyField = $this->studyFieldsRepository->store($requested);

        if (false == $studyField) {
            return redirect()->route('dashboard.studyFields.index')->with('error', __('messages.studyFields.createStudyFieldsError'));
        }

        return redirect()->route('dashboard.studyFields.index')->with('success', __('messages.studyFields.createStudyFieldsSuccess'));
    }

    public function show(string $id)
    {
        $studyField = $this->studyFieldsRepository->getOneById($id);

        if (null == $studyField) {
            return redirect()->route('dashboard.studyFields.index')->with('error', __('messages.studyFields.findStudyFieldsError'));
        }

        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'studyField' => $studyField
        ];

        return view('dashboard.studyFields.show', compact('data'));
    }

    public function edit(string $id)
    {
        $studyField = $this->studyFieldsRepository->getOneById($id);

        if (null == $studyField) {
            return redirect()->route('dashboard.studyFields.index')->with('error', __('messages.studyFields.findStudyFieldsError'));
        }

        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'studyField' => $studyField,
            'studyBases' => $this->studyBasesRepository->all(),
            'studyFields' => $this->studyFieldsRepository->all(),
        ];

        return view('dashboard.studyFields.edit', compact('data'));
    }

    public function update(CreateStudyFieldRequest $request, string $id)
    {
        $requested = $request->validated();

        $studyField = $this->studyFieldsRepository->getOneById($id);

        if (null === $studyField) {
            return redirect()->route('dashboard.studyFields.index')->with('error', __('messages.studyFields.findStudyFieldsError'));
        }

        $studyFieldUpdated = $this->studyFieldsRepository->update($id, $requested);

        if (false == $studyFieldUpdated) {
            return redirect()->route('dashboard.studyFields.index')->with('error', __('messages.studyFields.updateStudyFieldsError'));
        }

        return redirect()->route('dashboard.studyFields.index')->with('success', __('messages.studyFields.updateStudyFieldsSuccess'));
    }

    public function destroy(string $id)
    {
        $studyField = $this->studyFieldsRepository->getOneById($id);

        if (null === $studyField) {
            return redirect()->route('dashboard.studyFields.index')->with('error', __('messages.studyFields.findStudyFieldsError'));
        }

        $studyFieldDeleted = $this->studyFieldsRepository->destroy($id);

        if (true == $studyFieldDeleted){
            return response()->json(['status' => 1, 'message' => __('messages.studyFields.deleteStudyFieldsSuccess')]);
        }

        return response()->json(['status' => 0, 'message' => __('messages.studyFields.deleteStudyFieldsError')]);
    }
}
