<?php

namespace App\Repositories;

use App\Models\ScheduleTeacher;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ScheduleTeachersRepository extends BaseRepository
{
    public function connection(): Builder
    {
        return DB::table('schedule_teachers');
    }

    public function setModel(): string
    {
        return ScheduleTeacher::class;
    }

    public function getScheduleTeachersBySchoolId($schoolId)
    {
        return $this->setModel()::where('school_id', $schoolId)->get();
    }
}
