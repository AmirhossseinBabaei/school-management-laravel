<?php

namespace App\Handlers\CreateMethodControllersData;

use App\Abstracts\ControllerDataHandler;
use App\Repositories\ClassRoomRepository;
use App\Repositories\SchoolsRepository;
use App\Repositories\StudentsRepository;
use App\Repositories\StudyBasesRepository;
use App\Repositories\StudyFieldsRepository;
use App\Repositories\UsersRepository;
use App\Services\JalaliDateServiceStatic;
use Illuminate\Support\Facades\Auth;

class StudentsCreateControllerDataHandler extends ControllerDataHandler
{
    protected ControllerDataHandler $handler;

    protected StudentsRepository $studentsRepository;
    protected JalaliDateServiceStatic $jalaliDateService;
    protected SchoolsRepository $schoolsRepository;
    protected UsersRepository $usersRepository;
    protected StudyBasesRepository $studyBasesRepository;
    protected StudyFieldsRepository $studyFieldsRepository;
    protected ClassRoomRepository $classRoomRepository;

    public function __construct()
    {
        $this->studentsRepository = new StudentsRepository();
        $this->jalaliDateService = new JalaliDateServiceStatic();
        $this->schoolsRepository = new SchoolsRepository();
        $this->usersRepository = new UsersRepository();
        $this->studyBasesRepository = new StudyBasesRepository();
        $this->studyFieldsRepository = new StudyFieldsRepository();
        $this->classRoomRepository = new ClassRoomRepository();
    }

    public function setNext(ControllerDataHandler $handler): ControllerDataHandler
    {
        $this->next = $handler;

        return $handler;
    }

    protected function getAdminData(): array
    {
        return [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'schools' => $this->schoolsRepository->all(),
            'study_bases' => $this->studyBasesRepository->all(),
            'study_fields' => $this->studyFieldsRepository->all(),
            'classes' => $this->classRoomRepository->all(),
            'users' => $this->usersRepository->all()
        ];
    }

    public function getOwnerData(string $schoolId): array
    {
        return [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'study_bases' => $this->studyBasesRepository->all(),
            'study_fields' => $this->studyFieldsRepository->all(),
            'classes' => $this->classRoomRepository->getClassesBySchoolId($schoolId),
            'users' => $this->usersRepository->getUsersBySchoolId($schoolId)
        ];
    }

    public function handle(string $request)
    {
        if ($request == 'studentsData') {
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

        return null;
    }
}
