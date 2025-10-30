<?php

namespace App\Handlers\IndexMethodControllersData;

use App\Abstracts\ControllerDataHandler;
use App\Repositories\AttendancesRepository;
use App\Repositories\ClassRoomRepository;
use App\Repositories\LessonsRepository;
use App\Repositories\TeacherClassesRepository;
use App\Repositories\UsersRepository;
use App\Services\JalaliDateServiceStatic;
use Illuminate\Support\Facades\Auth;

class AttendancesControllerDataHandler extends ControllerDataHandler
{
    protected ClassRoomRepository $classRoomRepository;
    protected JalaliDateServiceStatic $dateServiceStatic;
    protected LessonsRepository $lessonsRepository;
    protected UsersRepository $usersRepository;
    protected TeacherClassesRepository $teacherClassesRepository;
    protected AttendancesRepository $attendancesRepository;

    protected ControllerDataHandler $handler;

    public function __construct()
    {
        $this->classRoomRepository = new ClassRoomRepository();
        $this->dateServiceStatic = new JalaliDateServiceStatic();
        $this->usersRepository = new UsersRepository();
        $this->lessonsRepository = new LessonsRepository();
        $this->attendancesRepository = new AttendancesRepository();
        $this->teacherClassesRepository = new TeacherClassesRepository();
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
            'classes' => $this->classRoomRepository->getClassesBySchoolId($schoolId),
            'lessons' => $this->lessonsRepository->all(),
            'teachers' => $this->usersRepository->getTeachersBySchoolId($schoolId)
        ];
    }

    public function getTeacherData($userId): array
    {
        return [
            'nowDate' => $this->dateServiceStatic->now('yyyy/MM/dd'),
            'classes' => $this->teacherClassesRepository
                ->setModel()
                ::with('classRoom')
                ->where('teacher_id', $userId)
                ->get(),

            'lessons' => $this->teacherClassesRepository
                ->setModel()
                ::with('lesson')
                ->where('teacher_id', $userId)
                ->get(),

            'teachers' => $this->usersRepository->getOneById($userId)
        ];
    }

    /**
     * @param ClassRoomRepository $classRoomRepository
     * @return AttendancesControllerDataHandler
     */

    public function handle(string $request)
    {
        if ($request == 'attendancesData') {

            if (Auth::user()->hasRole('admin')) {
                return $this->getAdminData();
            } else if (Auth::user()->hasRole('owner')) {
                return $this->getOwnerData(Auth::user()->school_id);
            } else if (Auth::user()->hasRole('deputy')) {
                return $this->getOwnerData(Auth::user()->school_id);
            } else if (Auth::user()->hasRole('teacher')) {
                return $this->getTeacherData(Auth::id());
            } else {
                return null;
            }
        }

        return null;
    }
}
