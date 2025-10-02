<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CreateSchoolsRequest;
use App\Repositories\SchoolsRepository;
use App\Services\JalaliDateService;
use App\Services\UuidService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SchoolsController extends Controller
{
    protected JalaliDateService $jalaliDateService;
    protected SchoolsRepository $schoolsRepository;
    protected UuidService $uuidService;

    public function __construct(
        JalaliDateService $jalaliDateService,
        SchoolsRepository $schoolsRepository
    )
    {
        $this->jalaliDateService = $jalaliDateService;
        $this->schoolsRepository = $schoolsRepository;
    }

    public function index()
    {
        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'schools' => $this->schoolsRepository->getAllByPaginate()
        ];

        return view('dashboard.schools.all', compact('data'));
    }

    public function create()
    {
        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd')
        ];

        return view('dashboard.schools.create', compact('data'));
    }

    public function store(CreateSchoolsRequest $request)
    {
        $requested = $request->validated();

        $requested['uuid'] = Str::uuid()->toString();

        $school = $this->schoolsRepository->store($requested);

        if (false === $school) {
            return redirect()->route('dashboard.schools.index')
                ->with('error', __('messages.schools.createSchoolsError'));
        }

        return redirect()->route('dashboard.schools.index')
            ->with('success', __('messages.schools.createSchoolsSuccess'));
    }

    public function show($id)
    {
        $school = $this->schoolsRepository->getOneById($id);

        if (null == $school) {
            return redirect()->route('dashboard.schools.index')
                ->with('success', __('messages.schools.findSchoolsError'));
        }

        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'school' => $school
        ];

        return view('dashboard.schools.show', compact('data'));
    }

    public function edit($id)
    {
        $school = $this->schoolsRepository->getOneById($id);

        if (null == $school) {
            return redirect()->route('dashboard.schools.index')
                ->with('success', __('messages.schools.findSchoolsError'));
        }

        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'school' => $school
        ];

        return view('dashboard.schools.edit', compact('data'));
    }

    public function update(CreateSchoolsRequest $request, $id)
    {
        $requested = $request->validated();

        $school = $this->schoolsRepository->getOneById($id);

        if (null === $school) {
            return redirect()->route('dashboard.schools.index')
                ->with('error', __('messages.schools.findSchoolsError'));
        }

        $updateSchool = $this->schoolsRepository->update($id, $requested);

        if (false == $updateSchool) {
            return redirect()->route('dashboard.schools.index')
                ->with('error', __('messages.schools.updateSchoolsError'));
        }

        return redirect()->route('dashboard.schools.index')
            ->with('success', __('messages.schools.updateSchoolsSuccess'));
    }

    public function destroy($id)
    {
        $school = $this->schoolsRepository->getOneById($id);

        if (null === $school) {
            return redirect()->route('dashboard.schools.index')
                ->with('error', __('messages.schools.findSchoolsError'));
        }

        $schoolDeleted = $this->schoolsRepository->destroy($id);
        if (false == $schoolDeleted) {
            return response()->json(['status' => 0, 'message' => __('messages.schools.deleteSchoolsError')]);
        }

        return response()->json(['status' => 1, 'message' => __('messages.schools.deleteSchoolsSuccess')]);
    }
}
