<?php

namespace App\Handlers\CreateMethodControllersData;

use App\Abstracts\ControllerDataHandler;
use App\Repositories\ClassRoomRepository;
use App\Repositories\StudyBasesRepository;
use App\Repositories\StudyFieldsRepository;
use App\Services\JalaliDateServiceStatic;
use Illuminate\Support\Facades\Auth;

class ClassRoomsCreateControllerData extends ControllerDataHandler
{
    protected ClassRoomRepository $classRoomRepository;
    protected StudyFieldsRepository $studyFieldsRepository;
    protected StudyBasesRepository $studyBasesRepository;

    protected JalaliDateServiceStatic $dateServiceStatic;

    protected ControllerDataHandler $handler;

    public function __construct()
    {
        $this->classRoomRepository = new ClassRoomRepository();
        $this->dateServiceStatic = new JalaliDateServiceStatic();
        $this->studyBasesRepository = new StudyBasesRepository();
        $this->studyFieldsRepository = new StudyFieldsRepository();
    }

    public function setNext(ControllerDataHandler $handler): ControllerDataHandler
    {
        $this->next = $handler;

        return $handler;
    }

    public function getAdminData(): array
    {
        return [
            'nowDate' => $this->dateServiceStatic->now('yyyy/MM/dd'),
            'schools' => $this->classRoomRepository->getAllByPaginate(),
            'studyBases' => $this->studyBasesRepository->all(),
            'studyFields' => $this->studyFieldsRepository->all()
        ];
    }

    public function getOwnerData($schoolId): array
    {
        return [
            'nowDate' => $this->dateServiceStatic->now('yyyy/MM/dd'),
            'studyBases' => $this->studyBasesRepository->all(),
            'studyFields' => $this->studyFieldsRepository->all()
        ];
    }

    public function handle(string $request)
    {
        if ($request == 'classRoomsData') {
            if (Auth::user()->hasRole('admin')) {
                return $this->getAdminData();
            } else if (Auth::user()->hasRole('owner')) {
                return $this->getOwnerData(Auth::user()->school_id);
            } else {
                return null;
            }
        }

        return $this->next->handle($request);;
    }
}
