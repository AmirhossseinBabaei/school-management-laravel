<?php

use App\Http\Controllers\Panel\DashboardController;
use App\Http\Controllers\Panel\UsersController;
use App\Http\Controllers\Panel\StudentsController;
use App\Http\Controllers\Panel\RolesController;
use App\Http\Controllers\Panel\StudyFiledsController;
use App\Http\Controllers\Panel\StudyBasesController;
use App\Http\Controllers\Panel\TermsController;
use App\Http\Controllers\Panel\SchoolsController;
use App\Http\Controllers\Panel\LessonsController;
use App\Http\Controllers\Panel\NotificationsController;
use App\Http\Controllers\Panel\ClassRoomController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->prefix('dashboard')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Test route for layout
        Route::get('/test-layout', function () {
            return view('test-layout');
        })->name('dashboard.test-layout');

        Route::resource('users', UsersController::class)->names('dashboard.users');

        Route::resource('students', StudentsController::class)->names('dashboard.students');

        Route::resource('roles', RolesController::class)->names('dashboard.roles');

        Route::resource('study-fields', StudyFiledsController::class)
            ->names('dashboard.studyFields');

        Route::resource('study-bases', StudyBasesController::class)
            ->names('dashboard.studyBases');

        Route::get('{id}/show-children', [StudyFiledsController::class, 'showChildrenOfStudyFields'])
            ->name('dashboard.studyFields.showChildren');

        Route::resource('terms', TermsController::class)->names('dashboard.terms');

        Route::resource('schools', SchoolsController::class)
            ->names('dashboard.schools');

        Route::resource('lessons', LessonsController::class)
            ->names('dashboard.lessons');

        Route::resource('/notifications', NotificationsController::class)
            ->names('dashboard.notifications');

        Route::get('/notifications-failed', [NotificationsController::class, 'allNotificationFailed'])
            ->name('dashboard.notifications.allFailed');

        Route::get('/notifications-failed/{id}', [NotificationsController::class, 'showNotificationFailed'])
        ->name('dashboard.notifications.showFailed');

        Route::resource('classRooms', ClassRoomController::class)
            ->names('dashboard.classRooms');
    });

require __DIR__ . '/auth.php';
