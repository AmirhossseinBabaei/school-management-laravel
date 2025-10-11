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
use App\Http\Controllers\Panel\ClassRoomsController;
use App\Http\Controllers\Panel\TeacherClassesController;
use App\Http\Controllers\Panel\ScheduleTeachersController;
use App\Http\Controllers\Panel\AttendanceController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->prefix('dashboard')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', UsersController::class)->names('dashboard.users');

        Route::resource('students', StudentsController::class)->names('dashboard.students');

        Route::resource('roles', RolesController::class)->names('dashboard.roles')
            ->middleware('isAdmin');

        Route::resource('study-fields', StudyFiledsController::class)
            ->names('dashboard.studyFields')
            ->middleware('isAdmin');;

        Route::resource('study-bases', StudyBasesController::class)
            ->names('dashboard.studyBases')
            ->middleware('isAdmin');;

        Route::get('{id}/show-children', [StudyFiledsController::class, 'showChildrenOfStudyFields'])
            ->name('dashboard.studyFields.showChildren')
            ->middleware('isAdmin');;

        Route::resource('terms', TermsController::class)
            ->names('dashboard.terms')
            ->middleware('isAdmin');;

        Route::resource('schools', SchoolsController::class)
            ->names('dashboard.schools')
            ->middleware('isAdmin');;

        Route::resource('lessons', LessonsController::class)
            ->names('dashboard.lessons')
            ->middleware('isAdmin');;

        Route::resource('/notifications', NotificationsController::class)
            ->names('dashboard.notifications');

        Route::get('/notifications-failed', [NotificationsController::class, 'allNotificationFailed'])
            ->name('dashboard.notifications.allFailed');

        Route::get('/notifications-failed/{id}', [NotificationsController::class, 'showNotificationFailed'])
        ->name('dashboard.notifications.showFailed');

        Route::get('/attendances/students/{classId}', [AttendanceController::class, 'getStudents'])
            ->name('dashboard.attendance.students');

        Route::resource('classRooms', ClassRoomsController::class)
            ->names('dashboard.classRooms');

        Route::resource('teacher-classes', TeacherClassesController::class)
            ->names('dashboard.teacherClasses');

        Route::resource('schedule-teachers', ScheduleTeachersController::class)
            ->names('dashboard.scheduleTeachers');

        Route::resource('attendances', AttendanceController::class)
        ->names('dashboard.attendances');
    });

require __DIR__ . '/auth.php';


