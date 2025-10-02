<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CreateTermRequest;
use App\Repositories\SchoolsRepository;
use App\Repositories\TermsRepository;
use App\Services\DateService;
use App\Services\JalaliDateService;
use App\Services\JalaliDateServiceStatic;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class TermsController extends Controller
{
    protected JalaliDateService $jalaliDateService;
    protected TermsRepository $termsRepository;
    protected SchoolsRepository $schoolsRepository;
    protected string $datePattern = 'yyyy/MM/dd';

    public function __construct(
        JalaliDateService $jalaliDateService,
        TermsRepository   $termsRepository,
        SchoolsRepository $schoolsRepository
    )
    {
        $this->jalaliDateService = $jalaliDateService;
        $this->termsRepository = $termsRepository;
        $this->schoolsRepository = $schoolsRepository;
    }

    public function index()
    {
        $data = [
            'nowDate' => $this->jalaliDateService->now($this->datePattern),
            'terms' => $this->termsRepository->getAllByPaginateAndWithSchools()
        ];

        return view('dashboard.terms.all', compact('data'));
    }

    public function create()
    {
        $data = [
            'nowDate' => $this->jalaliDateService->now($this->datePattern),
            'schools' => $this->schoolsRepository->all()
        ];

        return view('dashboard.terms.create', compact('data'));
    }

    public function store(CreateTermRequest $request)
    {
        $requested = $request->validated();

        $requested['from_date'] = JalaliDateServiceStatic::toGregorian($requested['from_date']);
        $requested['to_date'] = JalaliDateServiceStatic::toGregorian($requested['to_date']);

        $term = $this->termsRepository->store($requested);

        if (false == $term) {
            return redirect()->route('dashboard.terms.index')->with('error', __('messages.terms.createTermError'));
        }

        return redirect()->route('dashboard.terms.index')->with('success', __('messages.terms.createTermSuccess'));
    }

    public function show(string $id)
    {
        $term = $this->termsRepository->getOneById($id);

        if (null === $term) {
            return redirect()->route('dashboard.terms.index')->with('error', __('messages.terms.findTermError'));
        }

        $data = [
            'term' => $term,
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd')
        ];

        return view('dashboard.terms.show', compact('data'));
    }

    public function edit(string $id)
    {
        $term = $this->termsRepository->getOneById($id);

        if (null === $term)
        {
            return redirect()->route('dashboard.terms.index')->with('error', __('messages.terms.findTermError'));
        }

        $data = [
            'nowDate' => $this->jalaliDateService->now($this->datePattern),
            'schools' => $this->schoolsRepository->all(),
            'term' => $term
        ];

        return view('dashboard.terms.edit', compact('data'));
    }

    public function update(CreateTermRequest $request, string $id)
    {
        $requested = $request->validated();

        $requested['from_date'] = JalaliDateServiceStatic::toGregorian($requested['from_date']);
        $requested['to_date'] = JalaliDateServiceStatic::toGregorian($requested['to_date']);

        $term = $this->termsRepository->getOneById($id);

        if (null === $term)
        {
            return redirect()->route('dashboard.terms.index')->with('error', __('messages.terms.findTermError'));
        }

        $termUpdated = $this->termsRepository->update($id, $requested);

        if (false == $termUpdated){
            return redirect()->route('dashboard.terms.index')->with('error', __('messages.terms.updateTermError'));
        }

        return redirect()->route('dashboard.terms.index')->with('success', __('messages.terms.updateTermSuccess'));
    }

    public function destroy(string $id)
    {
        $term = $this->termsRepository->getOneById($id);

        if (null === $term) {
            return redirect()->route('dashboard.terms.index')->with('error', __('messages.terms.findTermError'));
        }

        $termUpdated = $this->termsRepository->destroy($id);

        if (true == $termUpdated) {
            return response()->json(['status' => 1, 'message' => __('messages.terms.deleteTermSuccess')]);
        }

        return response()->json(['status' => 0, 'message' => __('messages.users.deleteTermError')]);
    }
}
