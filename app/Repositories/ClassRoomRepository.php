<?php

namespace App\Repositories;

use App\Models\ClassRoom;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ClassRoomRepository extends BaseRepository
{
    public function connection(): Builder
    {
        return DB::table('classes');
    }

    public function setModel()
    {
        return ClassRoom::class;
    }

    public function getOneById($id)
    {
        return $this->setModel()::find($id);
    }

    public function getCountClassRoomsBySchoolId($id): string
    {
        return $this->setModel()::where('school_id', $id)->pluck('id')->count();
    }

    public function all()
    {
        return $this->setModel()::all();
    }

    public function getClassesBySchoolId($schoolId)
    {
        return $this->setModel()::where('school_id', $schoolId)->orderBy('id', 'desc')->paginate(10);
    }
}
