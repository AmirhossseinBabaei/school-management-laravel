<?php

namespace App\Providers;

use App\Handlers\CreateMethodControllersData\ClassRoomsCreateControllerData;
use App\Handlers\CreateMethodControllersData\StudentsCreateControllerDataHandler;
use App\Handlers\CreateMethodControllersData\TeacherClassesCreateControllerDataHandler;
use App\Handlers\IndexMethodControllersData\AttendancesControllerDataHandler;
use App\Handlers\IndexMethodControllersData\ClassRoomsControllerDataHandler;
use App\Handlers\IndexMethodControllersData\DashboardControllerDataHandler;
use App\Handlers\IndexMethodControllersData\ScheduleTeachersControllerDataHandler;
use App\Handlers\IndexMethodControllersData\StudentsControllerDataHandler;
use App\Handlers\IndexMethodControllersData\TeacherClassesControllerDataHandler;
use App\Handlers\IndexMethodControllersData\UsersControllerDataHandler;
use App\Handlers\Notifications\{
    AbsentStudentsHandler,
    AllAttendanceSchoolHandler,
    AllOwnersHandler,
    AllSchoolHandler,
    AllSchoolStudentsHandler,
    AllTeachersHandler,
    AllUsersHandler,
    ClassHandler,
    DebtStudentsHandler,
    LowGradeStudentsHandler,
    MultipleStudentsHandler,
    ParentHandler,
    StudentHandler,
    StudyBaseHandler
};
use App\Models\Attendance;
use App\Models\Student;
use App\Models\User;
use App\Policies\AttendancePolicy;
use App\Policies\StudentPolicy;
use App\Policies\UserPolicy;
use App\Repositories\AttendancesRepository;
use App\Repositories\GradesRepository;
use App\Repositories\StudentsRepository;
use App\Repositories\UsersRepository;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected array $policies = [
        User::class => UserPolicy::class,
        Student::class => StudentPolicy::class,
        Attendance::class => AttendancePolicy::class
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('admin', function () {
            return "<?php if(auth()->check() && auth()->user()->role_id === 1): ?>";
        });

        Blade::directive('endadmin', function () {
            return "<?php endif; ?>";
        });

        //@owner directive
        Blade::directive('owner', function () {
            return "<?php if(auth()->check() && auth()->user()->role_id === 2): ?>";
        });

        Blade::directive('endowner', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('deputy', function () {
            return "<?php if (auth()->check() && auth()->user()->role_id === 4): ?>";
        });

        Blade::directive('enddeputy', function (){
            return "<?php endif; ?>";
        });

        Blade::directive('teacher', function () {
            return "<?php if (auth()->check() && auth()->user()->role_id === 3): ?>";
        });

        Blade::directive('endteacher', function (){
            return "<?php endif; ?>";
        });

        Blade::directive('student', function () {
            return "<?php if (auth()->check() && auth()->user()->role_id === 5): ?>";
        });

        Blade::directive('endstudent', function (){
            return "<?php endif; ?>";
        });

        Blade::directive('notstudent', function () {
            return "<?php if (auth()->check() && auth()->user()->role_id !== 5): ?>";
        });

        Blade::directive('endnotstudent', function (){
            return "<?php endif; ?>";
        });

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        Paginator::useBootstrap();

        $this->app->singleton('chain.notification', function ($app) {
            $allUsers = new AllUsersHandler(new UsersRepository());
            $allOwners = new AllOwnersHandler(new UsersRepository());
            $allTeachers = new AllTeachersHandler(new UsersRepository());
            $allAttendanceSchools = new AllAttendanceSchoolHandler(new AttendancesRepository());
            $allSchoolStudents = new AllSchoolStudentsHandler(new StudentsRepository());
            $absentStudents = new AbsentStudentsHandler(new AttendancesRepository());
            $debtStudents = new DebtStudentsHandler(new StudentsRepository());
            $lowGradeStudents = new LowGradeStudentsHandler(new GradesRepository(), new StudentsRepository());
            $student = new StudentHandler(new StudentsRepository());
            $parent = new ParentHandler(new StudentsRepository());
            $multipleStudents = new MultipleStudentsHandler(new StudentsRepository());
            $class = new ClassHandler(new StudentsRepository());
            $studyBase = new StudyBaseHandler(new StudentsRepository());

            $allUsers->setNext($allOwners)
                ->setNext($allTeachers)
                ->setNext($allAttendanceSchools)
                ->setNext($allSchoolStudents)
                ->setNext($absentStudents)
                ->setNext($debtStudents)
                ->setNext($lowGradeStudents)
                ->setNext($student)
                ->setNext($parent)
                ->setNext($multipleStudents)
                ->setNext($class)
                ->setNext($studyBase);

            return $allUsers;
        });

        $this->app->singleton('chain.indexMethodControllersData', function (){
            $dashboardControllerData = new DashboardControllerDataHandler();
            $usersControllerData = new UsersControllerDataHandler();
            $studentsControllersData = new StudentsControllerDataHandler();
            $classRoomControllerData = new ClassRoomsControllerDataHandler();
            $teacherClassesControllerData = new TeacherClassesControllerDataHandler();
            $attendacesControllerData = new AttendancesControllerDataHandler();

            $dashboardControllerData->setNext($usersControllerData)->setNext($studentsControllersData)
            ->setNext($classRoomControllerData)->setNext($teacherClassesControllerData)
            ->setNext($attendacesControllerData);

            return $dashboardControllerData;
        });

        $this->app->singleton('chain.createMethodControllersData', function (){
            $studentsControllersData = new StudentsCreateControllerDataHandler();
            $classRoomsControllerData = new ClassRoomsCreateControllerData();
            $teacherClassesControllerData = new TeacherClassesCreateControllerDataHandler();

            $studentsControllersData->setNext($classRoomsControllerData)->setNext($teacherClassesControllerData);

            return $studentsControllersData;
        });
    }
}
