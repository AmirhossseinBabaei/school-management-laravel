<?php

namespace App\Handlers\IndexMethodControllersData;

use App\Abstracts\ControllerDataHandler;
use App\Repositories\TeacherClassesRepository;
use App\Services\JalaliDateServiceStatic;
use Illuminate\Support\Facades\Auth;

class TeacherClassesControllerDataHandler extends ControllerDataHandler
{
    protected TeacherClassesRepository $teacherClassesRepository;
    protected JalaliDateServiceStatic $jalaliDateService;

    protected ControllerDataHandler $next;

    public function __construct()
    {
        $this->teacherClassesRepository = new TeacherClassesRepository();
        $this->jalaliDateService = new JalaliDateServiceStatic();
    }

    public function setNext(ControllerDataHandler $handler): ControllerDataHandler
    {
        $this->next = $handler;

        return $handler;
    }

    public function adminData(): array
    {
        return [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'teacherClasses' => $this->teacherClassesRepository->getAllByPaginate()
        ];
    }

    public function ownerData(string $schoolId): array
    {
        return [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'teacherClasses' => $this->teacherClassesRepository->getTeacherClassesBySchoolId($schoolId),
        ];
    }

    public function handle(string $request)
    {
        if ($request == 'TeacherClassesData') {
            if (Auth::user()->hasRole('admin')) {

                return $this->adminData();
            }

            else if (Auth::user()->hasRole('owner')) {
                $schoolId = Auth::user()->school_id;

                return $this->ownerData($schoolId);
            }
            else {
                return $this->adminData();
            }
        }

        return $this->next->handle($request);
    }
}
