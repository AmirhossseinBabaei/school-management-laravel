<?php

namespace App\Providers;

use App\Handlers\CreateMethodControllersData\StudentsCreateControllerDataHandler;
use App\Handlers\IndexMethodControllersData\ClassRoomsControllerDataHandler;
use App\Handlers\IndexMethodControllersData\DashboardControllerDataHandler;
use App\Handlers\IndexMethodControllersData\StudentsControllerDataHandler;
use App\Handlers\IndexMethodControllersData\UsersControllerDataHandler;
use App\Handlers\Notifications\{AllAttendanceSchoolHandler, AllOwnersHandler, AllUsersHandler, StudentHandler};
use App\Models\Student;
use App\Models\User;
use App\Policies\StudentPolicy;
use App\Policies\UserPolicy;
use App\Repositories\AttendancesRepository;
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
        Student::class => StudentPolicy::class
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

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        Paginator::useBootstrap();

        $this->app->singleton('chain.notification', function ($app) {
            $allUsers = new AllUsersHandler(new UsersRepository());
            $allOwners = new AllOwnersHandler(new UsersRepository());
            $allAttendanceSchools = new AllAttendanceSchoolHandler(new AttendancesRepository());
            $student = new StudentHandler(new StudentsRepository());

            $allUsers->setNext($allOwners)->setNext($allAttendanceSchools)->setNext($student);

            return $allUsers;
        });

        $this->app->singleton('chain.indexMethodControllersData', function (){
            $dashboardControllerData = new DashboardControllerDataHandler();
            $usersControllerData = new UsersControllerDataHandler();
            $studentsControllersData = new StudentsControllerDataHandler();
            $classRoomControllerData = new ClassRoomsControllerDataHandler();

            $dashboardControllerData->setNext($usersControllerData)->setNext($studentsControllersData)
            ->setNext($classRoomControllerData);

            return $dashboardControllerData;
        });

        $this->app->singleton('chain.createMethodControllersData', function (){
            $studentsControllersData = new StudentsCreateControllerDataHandler();

            return $studentsControllersData;
        });
    }
}
