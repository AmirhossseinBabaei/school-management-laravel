<?php

namespace App\Handlers\IndexMethodControllersData;

use App\Abstracts\ControllerDataHandler;
use App\Repositories\AttendancesRepository;
use App\Repositories\ClassRoomRepository;
use App\Repositories\SchoolsRepository;
use App\Repositories\StudentsRepository;
use App\Repositories\UsersRepository;
use App\Services\JalaliDateService;
use App\Services\JalaliDateServiceStatic;
use App\Services\UsersService;
use Illuminate\Support\Facades\Auth;

class DashboardControllerDataHandler extends ControllerDataHandler
{
    protected ControllerDataHandler $next;

    protected UsersRepository $usersRepository;
    protected StudentsRepository $studentsRepository;
    protected SchoolsRepository $schoolsRepository;
    protected JalaliDateServiceStatic $jalaliDateService;
    protected ClassRoomRepository $classRoomRepository;
    protected AttendancesRepository $attendancesRepository;

    protected UsersService $userService;

    public function __construct()
    {
        $this->usersRepository = new UsersRepository();
        $this->studentsRepository = new StudentsRepository();
        $this->schoolsRepository = new SchoolsRepository();
        $this->jalaliDateService = new JalaliDateServiceStatic();
        $this->classRoomRepository = new ClassRoomRepository();
        $this->attendancesRepository = new AttendancesRepository();

        $this->userService = new UsersService($this->usersRepository);
    }

    public function setNext(ControllerDataHandler $handler): ControllerDataHandler
    {
        $this->next = $handler;
        return $handler;
    }

    public function getAdminData(): array
    {
        return [
            'studentsCount' => $this->studentsRepository->count(),
            'ownerUsersCount' => $this->usersRepository->getOwnersCount(),
            'schoolsCount' => $this->schoolsRepository->count(),
            'lastCreatedSchoolTime' => $this->jalaliDateService
                ->toJalali($this->schoolsRepository->lastRecord()->created_at, 'yyyy/MM/dd HH:mm:ss'),
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'dataChartOwners' => $this->userService->getNewOwnersByDateOfWeek()
        ];
    }

    public function getOwnerData($schoolId): array
    {
        return [
            'studentsCount' => $this->studentsRepository->getCountStudentsBySchoolId($schoolId),
            'teachersCount' => $this->usersRepository->getCountTeachersBySchoolId($schoolId),
            'classRoomCount' => $this->classRoomRepository->getCountClassRoomsBySchoolId($schoolId),
            'absentStudentsTodayCount' => $this->attendancesRepository->getAbsentStudentsTodayCount($schoolId),
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd')
        ];
    }

    public function handle(string $request)
    {
        if ($request == 'dashboardData') {

            if (Auth::user()->hasRole('admin')) {

                return $this->getAdminData();
            } else if ($request == Auth::user()->hasRole('owner')) {

                $schoolId = Auth::user()->school_id;

                return $this->getOwnerData($schoolId);
            } else {
                return $this->getAdminData();
            }
        }

        return $this->next->handle($request);
    }
}
