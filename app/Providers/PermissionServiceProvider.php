<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // @role directive
        Blade::directive('admin1', function () {
            return "<?php if(auth()->check() && auth()->user()->role_id === 1): ?>";
        });

        Blade::directive('endadmin1', function () {
            return "<?php endif; ?>";
        });

        //@owner directive
        Blade::directive('owner1', function () {
            return "<?php if(auth()->check() && auth()->user()->role_id === 2): ?>";
        });

        Blade::directive('endowner1', function () {
            return "<?php endif; ?>";
        });

        // @permission directive
        Blade::directive('permission', function ($permission) {
            return "<?php if(auth()->check() && auth()->user()->hasPermission($permission)): ?>";
        });

        Blade::directive('endpermission', function () {
            return "<?php endif; ?>";
        });

        // @anyrole directive
        Blade::directive('anyrole', function ($roles) {
            return "<?php if(auth()->check() && auth()->user()->hasAnyRole($roles)): ?>";
        });

        Blade::directive('endanyrole', function () {
            return "<?php endif; ?>";
        });

        // @allroles directive
        Blade::directive('allroles', function ($roles) {
            return "<?php if(auth()->check() && auth()->user()->hasAllRoles($roles)): ?>";
        });

        Blade::directive('endallroles', function () {
            return "<?php endif; ?>";
        });

        // @canany directive (for multiple permissions)
        Blade::directive('canany', function ($permissions) {
            return "<?php if(auth()->check() && auth()->user()->hasAnyPermission($permissions)): ?>";
        });

        Blade::directive('endcanany', function () {
            return "<?php endif; ?>";
        });

        // @admin directive
        Blade::directive('admin', function () {
            return "<?php if(auth()->check() && auth()->user()->isAdmin()): ?>";
        });

        Blade::directive('endadmin', function () {
            return "<?php endif; ?>";
        });

        // @teacher directive
        Blade::directive('teacher', function () {
            return "<?php if(auth()->check() && auth()->user()->isTeacher()): ?>";
        });

        Blade::directive('endteacher', function () {
            return "<?php endif; ?>";
        });

        // @student directive
        Blade::directive('student', function () {
            return "<?php if(auth()->check() && auth()->user()->isStudent()): ?>";
        });

        Blade::directive('endstudent', function () {
            return "<?php endif; ?>";
        });

        // @owner directive (for school owners)
        Blade::directive('owner', function () {
            return "<?php if(auth()->check() && auth()->user()->isOwner()): ?>";
        });

        Blade::directive('endowner', function () {
            return "<?php endif; ?>";
        });
    }
}
