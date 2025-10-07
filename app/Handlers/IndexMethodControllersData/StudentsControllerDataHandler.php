<?php

namespace App\Handlers\IndexMethodControllersData;

use App\Abstracts\ControllerDataHandler;
use App\Repositories\ClassRoomRepository;
use App\Repositories\SchoolsRepository;
use App\Repositories\StudentsRepository;
use App\Repositories\StudyBasesRepository;
use App\Repositories\StudyFieldsRepository;
use App\Repositories\UsersRepository;
use App\Services\JalaliDateServiceStatic;
use Illuminate\Support\Facades\Auth;

class StudentsControllerDataHandler extends ControllerDataHandler
{
    protected StudentsRepository $studentsRepository;
    protected JalaliDateServiceStatic $jalaliDateService;

    protected ControllerDataHandler $next;

    public function __construct()
    {
        $this->studentsRepository = new StudentsRepository();
        $this->jalaliDateService = new JalaliDateServiceStatic();
    }

    public function setNext(ControllerDataHandler $handler): ControllerDataHandler
    {
        $this->next = $handler;
        return $handler;
    }

    public function getAdminData(): array
    {
        return [
            'students' => $this->studentsRepository->getAllStudentsWithRelations(),
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd')
        ];
    }

    public function getOwnerData($schoolId): array
    {
        return [
            'students' => $this->studentsRepository->getPaginateStudentsBySchoolId($schoolId),
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd')
        ];
    }

    public function handle(string $request)
    {
        if ($request == 'studentsData'){
            if (Auth::user()->hasRole('admin')) {
                return $this->getAdminData();
            }
            else if (Auth::user()->hasRole('owner')) {
                return $this->getOwnerData(Auth::user()->school_id);
            }
            else {
                return null;
            }
        }
        return $this->next->handle($request);
    }
}
