<?php

namespace App\Repositories;

use App\Models\TeacherClass;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class TeacherClassesRepository extends BaseRepository
{
    public function connection(): Builder
    {
        return DB::table('teacher_classes');
    }

    public function setModel(): string
    {
        return TeacherClass::class;
    }

    public function getTeacherClassesBySchoolId($schoolId)
    {
        return $this->setModel()::where('school_id', $schoolId)->orderBy('id', 'desc')->paginate(10);
    }

    public function getOneById($id)
    {
        return $this->setModel()::where('id', $id)->first();
    }
}
