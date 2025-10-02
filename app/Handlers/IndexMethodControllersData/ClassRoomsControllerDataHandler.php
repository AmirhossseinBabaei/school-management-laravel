<?php

namespace App\Handlers\IndexMethodControllersData;

use App\Abstracts\ControllerDataHandler;
use App\Repositories\ClassRoomRepository;
use App\Services\JalaliDateServiceStatic;
use Illuminate\Support\Facades\Auth;

class ClassRoomsControllerDataHandler extends ControllerDataHandler
{
    protected ClassRoomRepository $classRoomRepository;
    protected JalaliDateServiceStatic $dateServiceStatic;

    protected ControllerDataHandler $handler;

    public function __construct()
    {
        $this->classRoomRepository = new ClassRoomRepository();
        $this->dateServiceStatic = new JalaliDateServiceStatic();
    }

    public function setNext(ControllerDataHandler $handler): ControllerDataHandler
    {
        $this->next = $handler;
        return $handler;
    }

    protected function getAdminData(): array
    {
        return [
            'nowDate' => $this->dateServiceStatic->now('yyyy/MM/dd'),
            'classRooms' => $this->classRoomRepository->getAllByPaginate(),
        ];
    }

    protected function getOwnerData($schoolId): array
    {
        return [
            'nowDate' => $this->dateServiceStatic->now('yyyy/MM/dd'),
            'classRooms' => $this->classRoomRepository->getClassesBySchoolId($schoolId)
        ];
    }

    public function handle(string $request)
    {
        if ($request == 'classRoomsData') {

            if (Auth::user()->hasRole('admin')) {
                return $this->getAdminData();
            }
            else if (Auth::user()->hasRole('owner')){
                return $this->getOwnerData(Auth::user()->school_id);
            }
            else {
                return null;
            }
        }

        return null;
    }
}
