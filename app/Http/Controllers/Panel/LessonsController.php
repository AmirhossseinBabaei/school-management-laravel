<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CreateLessonsRequest;
use App\Repositories\LessonsRepository;
use App\Repositories\StudyBasesRepository;
use App\Repositories\StudyFieldsRepository;
use App\Services\JalaliDateService;
use Illuminate\Http\Request;

class LessonsController extends Controller
{
    protected LessonsRepository $lessonsRepository;
    protected StudyBasesRepository $studyBasesRepository;
    protected StudyFieldsRepository $studyFieldsRepository;

    protected JalaliDateService $jalaliDateService;

    public function __construct(
        LessonsRepository     $lessonsRepository,
        JalaliDateService     $jalaliDateService,
        StudyFieldsRepository $studyFieldsRepository,
        StudyBasesRepository  $studyBasesRepository
    )
    {
        $this->lessonsRepository = $lessonsRepository;
        $this->jalaliDateService = $jalaliDateService;
        $this->studyFieldsRepository = $studyFieldsRepository;
        $this->studyBasesRepository = $studyBasesRepository;
    }

    public function index()
    {
        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'lessons' => $this->lessonsRepository->getAllByPaginate()
        ];

        return view('dashboard.lessons.all', compact('data'));
    }

    public function create()
    {
        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'study_bases' => $this->studyBasesRepository->all(),
            'study_fields' => $this->studyFieldsRepository->all()
        ];

        return view('dashboard.lessons.create', compact('data'));
    }

    public function store(CreateLessonsRequest $request)
    {
        $requested = $request->validated();

        $lesson = $this->lessonsRepository->store($requested);

        if (false === $lesson) {
            return redirect()->route('dashboard.lessons.index')
                ->with('error', __('messages.lessons.createLessonsError'));
        }

        return redirect()->route('dashboard.lessons.index')
            ->with('success', __('messages.lessons.createLessonsSuccess'));
    }

    public function show(string $id)
    {
        $lesson = $this->lessonsRepository->getOneById($id);

        if (null === $lesson) {
            return redirect()->route('dashboard.lessons.index')
                ->with('error', __('messages.lessons.findLessonsError'));
        }

        $data = [
            'lesson' => $lesson,
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd')
        ];

        return view('dashboard.lessons.show', compact('data'));
    }

    public function edit(string $id)
    {
        $lesson = $this->lessonsRepository->getOneById($id);

        if (null === $lesson) {
            return redirect()->route('dashboard.lessons.index')
                ->with('error', __('messages.lessons.findLessonsError'));
        }

        $data = [
            'lesson' => $lesson,
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'study_fields' => $this->studyFieldsRepository->all(),
            'study_bases' => $this->studyBasesRepository->all()
        ];

        return view('dashboard.lessons.edit', compact('data'));
    }

    public function update(CreateLessonsRequest $request, string $id)
    {
        $requested = $request->validated();

        $lesson = $this->lessonsRepository->getOneById($id);

        if (null === $lesson) {
            return redirect()->route('dashboard.lessons.index')
                ->with('error', __('messages.lessons.findLessonError'));
        }

        $updateLesson = $this->lessonsRepository->update($id, $requested);

        if (false == $updateLesson) {
            return redirect()->route('dashboard.lessons.index')
                ->with('error', __('messages.lessons.updateLessonsError'));
        }

        return redirect()->route('dashboard.lessons.index')
            ->with('success', __('messages.lessons.updateLessonsSuccess'));
    }

    public function destroy(string $id)
    {
        $lesson = $this->lessonsRepository->getOneById($id);

        if (null === $lesson) {
            return redirect()->route('dashboard.lessons.index')
                ->with('error', __('messages.lessons.findLessonsError'));
        }

        $lessonDeleted = $this->lessonsRepository->destroy($id);

        if (true == $lessonDeleted) {
            return response()->json(['status' => 1, 'message' => __('messages.lessons.deleteLessonsSuccess')]);
        }

        return response()->json(['status' => 0, 'message' => __('messages.lessons.deleteLessonsError')]);
    }
}
