<?php

namespace App\Repositories;

use App\Models\Attendance;
use App\Services\JalaliDateServiceStatic;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendancesRepository extends BaseRepository
{
    public function connection(): Builder
    {
        return DB::table('attendances');
    }

    public function setModel()
    {
        return Attendance::class;
    }

    public function getPhoneStudentsAttendance(): array
    {
        return $this->connection()
            ->join('students', 'attendances.student_id', '=', 'students.id')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->where('students.school_id', Auth::user()->school_id)
            ->select( 'users.phone')
            ->distinct()
            ->get();
    }

    public function getAbsentStudentsTodayCount($schoolId): string
    {
        return $this->setModel()::where('school_id', $schoolId)
            ->where('created_at', '>', Carbon::now()->format('Y-m-d'))->where('status', 'absent')
            ->pluck('id')->count();
    }

    public function all()
    {
        return $this->setModel()::all();
    }
}
