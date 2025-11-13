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
use App\Http\Controllers\Panel\AttendancesController;
use App\Http\Controllers\Panel\GradesController;
use App\Http\Controllers\Panel\ReportCardsController;
use App\Http\Controllers\Panel\DisciplinaryRecordsController;
use App\Http\Controllers\Panel\IndexController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->prefix('dashboard')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', UsersController::class)->names('dashboard.users');

        Route::resource('students', StudentsController::class)->names('dashboard.students');

        Route::post('students/import-by-excel', [StudentsController::class, 'createByExcel'])
        ->name('dashboard.students.importByExcel');

        Route::post('students/create-by-excel', [UsersController::class, 'createByExcel'])
        ->name('dashboard.students.crateByExcel');

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

        Route::resource('notifications', NotificationsController::class)
            ->names('dashboard.notifications');

        Route::get('notifications-failed', [NotificationsController::class, 'allNotificationFailed'])
            ->name('dashboard.notifications.allFailed');

        Route::get('notifications-failed/{id}', [NotificationsController::class, 'showNotificationFailed'])
        ->name('dashboard.notifications.showFailed');

        Route::get('attendances/students/{classId}', [AttendancesController::class, 'getStudents'])
            ->name('dashboard.attendance.students');

        Route::resource('classRooms', ClassRoomsController::class)
            ->names('dashboard.classRooms');

        Route::resource('teacher-classes', TeacherClassesController::class)
            ->names('dashboard.teacherClasses');

        Route::resource('schedule-teachers', ScheduleTeachersController::class)
            ->names('dashboard.scheduleTeachers');

        Route::resource('attendances', AttendancesController::class)
        ->names('dashboard.attendances');

        Route::get('attendances/search-by-national-code', [AttendancesController::class, 'searchByNationalCode'])
            ->name('dashboard.attendances.searchByNationalCode');
        Route::post('attendances/search-by-national-code', [AttendancesController::class, 'getStudentAbsences'])
            ->name('dashboard.attendances.getStudentAbsences');
        Route::post('attendances/update-status', [AttendancesController::class, 'updateAttendanceStatus'])
            ->name('dashboard.attendances.updateStatus');

        Route::resource('grades', GradesController::class)
            ->names('dashboard.grades');

        Route::post('get-grade-students-data', [GradesController::class, 'getGradeStudentsData'])
            ->name('dashboard.grades.getStudentsWithGrades');

        Route::get('report-cards', [ReportCardsController::class, 'index'])
            ->name('dashboard.reportCards.index');
        Route::post('report-cards/fetch', [ReportCardsController::class, 'fetch'])
            ->name('dashboard.reportCards.fetch');
        Route::get('report-cards/class', [ReportCardsController::class, 'classIndex'])
            ->name('dashboard.reportCards.class.index');
        Route::post('report-cards/class/fetch', [ReportCardsController::class, 'fetchClass'])
            ->name('dashboard.reportCards.class.fetch');

        Route::get('disciplinary-records/create', [DisciplinaryRecordsController::class, 'create'])
            ->name('dashboard.disciplinaryRecords.create');
        Route::post('disciplinary-records', [DisciplinaryRecordsController::class, 'store'])
            ->name('dashboard.disciplinaryRecords.store');
        Route::get('disciplinary-records/report', [DisciplinaryRecordsController::class, 'report'])
            ->name('dashboard.disciplinaryRecords.report');
        Route::post('disciplinary-records/report', [DisciplinaryRecordsController::class, 'fetchReport'])
            ->name('dashboard.disciplinaryRecords.fetch');

        Route::get('reports', function () {
            return view('dashboard.reports.index');
        })->name('dashboard.reports.index');

        Route::get('get-report/attendances', [AttendancesController::class, 'getReportPageData'])
            ->name('dashboard.attendance.reports');

        Route::get('get-report-by-chart-type/attendances',
            [AttendancesController::class, 'getReportChartsPageData'])
            ->name('dashboard.attendances.charts');

        Route::post('get-attendance-students-data',
            [AttendancesController::class, 'getAttendanceStudentsData']);
    });

    Route::get('/', function(){
        return view('dashboard.showCase.index');
    });

    Route::view('/contact', 'contact')->name('contact');

    Route::get('download-apk-file-system', [IndexController::class, 'downloadApkFile']);

    // Phone login (view-only) routes
    Route::get('login', function () {
        return view('auth.phone-login');
    })->name('login');

    Route::get('auth/checkPhone', [\App\Http\Controllers\Panel\AuthController::class, 'loginByPhoneNumber'])->name('auth.checkPhone');

    Route::get('login/verify', function () {
        return view('auth.phone-verify');
    })->name('auth.phone.verify');

    Route::post('auth/check-and-login-by-phone', [\App\Http\Controllers\Panel\AuthController::class, 'checkAndLogin'])
    ->name('checkAndLoginByPhone');

require __DIR__ . '/auth.php';


