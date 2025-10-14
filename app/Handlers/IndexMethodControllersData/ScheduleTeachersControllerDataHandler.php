<?php

namespace App\Handlers\IndexMethodControllersData;

use App\Abstracts\ControllerDataHandler;
use App\Repositories\AttendancesRepository;
use App\Repositories\ClassRoomRepository;
use App\Repositories\LessonsRepository;
use App\Repositories\ScheduleTeachersRepository;
use App\Repositories\SchoolsRepository;
use App\Repositories\StudentsRepository;
use App\Repositories\UsersRepository;
use App\Services\JalaliDateService;
use App\Services\JalaliDateServiceStatic;
use App\Services\UsersService;
use Illuminate\Support\Facades\Auth;

class ScheduleTeachersControllerDataHandler extends ControllerDataHandler
{
    protected JalaliDateService $jalaliDateService;
    protected ScheduleTeachersRepository $scheduleTeachersRepository;
    protected UsersRepository $usersRepository;
    protected LessonsRepository $lessonsRepository;
    protected ClassRoomRepository $classRoomRepository;

    protected ControllerDataHandler $next;

    public function __construct()
    {
        $this->jalaliDateService = new JalaliDateService();
        $this->usersRepository = new UsersRepository();
        $this->lessonsRepository = new LessonsRepository();
        $this->classRoomRepository = new ClassRoomRepository();
        $this->scheduleTeachersRepository = new ScheduleTeachersRepository();
    }

    public function setNext(ControllerDataHandler $handler): ControllerDataHandler
    {
        $this->next = $handler;
        return $handler;
    }

    public function getAdminData(): array
    {
        return [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
        ];
    }

    public function getOwnerData($schoolId): array
    {
        return [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd'),
            'schedule_teachers' =>
                $this->scheduleTeachersRepository
                    ->getScheduleTeachersBySchoolId($schoolId),
            'teachers' => $this->usersRepository->getTeachersBySchoolId($schoolId),
            'lessons' => $this->lessonsRepository->all(),
            'classes' => $this->classRoomRepository->getClassesBySchoolId($schoolId)
        ];
    }

    public function handle(string $request)
    {
        if ($request == 'scheduleTeachersData') {

            if (Auth::user()->hasRole('admin')) {

                return $this->getAdminData();
            } else if ($request == Auth::user()->hasRole('owner')) {

                return $this->getOwnerData(Auth::user()->school_id);
            } else {
                return null;
            }
        }

        return $this->next->handle($request);
    }
}
