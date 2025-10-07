<?php

namespace App\Handlers\CreateMethodControllersData;

use App\Abstracts\ControllerDataHandler;
use App\Repositories\ClassRoomRepository;
use App\Repositories\LessonsRepository;
use App\Repositories\SchoolsRepository;
use App\Repositories\UsersRepository;
use App\Services\JalaliDateServiceStatic;
use Illuminate\Support\Facades\Auth;

class TeacherClassesCreateControllerDataHandler extends ControllerDataHandler
{
    protected ControllerDataHandler $handler;

    protected JalaliDateServiceStatic $jalaliDateService;

    protected SchoolsRepository $schoolsRepository;
    protected ClassRoomRepository $classRoomRepository;
    protected LessonsRepository $lessonsRepository;
    protected UsersRepository $usersRepository;

    public function __construct()
    {
        $this->schoolsRepository = new SchoolsRepository();
        $this->classRoomRepository = new ClassRoomRepository();
        $this->lessonsRepository = new LessonsRepository();
        $this->usersRepository = new UsersRepository();
        $this->jalaliDateService = new JalaliDateServiceStatic();
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
            'classRooms' => $this->classRoomRepository->all(),
            'lessons' => $this->lessonsRepository->all(),
            'users' => $this->usersRepository->getAllTeachers()
        ];
    }

    public function getOwnerData(string $schoolId): array
    {
        return [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'classRooms' => $this->classRoomRepository->getClassesBySchoolId($schoolId),
            'lessons' => $this->lessonsRepository->all(),
            'teachers' => $this->usersRepository->getTeachersBySchoolId($schoolId)
        ];
    }

    public function handle(string $request)
    {
        if ($request == 'TeacherClassesData') {
            if (Auth::user()->hasRole('admin')) {

                return $this->getAdminData();
            } else if (Auth::user()->hasRole('owner')) {
                return $this->getOwnerData(Auth::user()->school_id);
            } else {
                return null;
            }
        }

        return null;
    }
}
