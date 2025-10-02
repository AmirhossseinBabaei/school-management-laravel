<?php

namespace App\Repositories;

use App\Models\Lesson;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class LessonsRepository extends BaseRepository
{
    public function connection(): Builder
    {
        return DB::table('lessons');
    }

    public function setModel()
    {
        return Lesson::class;
    }

    public function getOneById($id)
    {
        return $this->setModel()::find($id);
    }
}
