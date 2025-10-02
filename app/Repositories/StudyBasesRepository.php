<?php

namespace App\Repositories;

use App\Models\StudyBase;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class StudyBasesRepository extends BaseRepository
{
    public function connection(): Builder
    {
        return DB::table('study_bases');
    }

    protected function setModel()
    {
        return StudyBase::class;
    }

    public function getOneById($id)
    {
        return StudyBase::find($id);
    }
}
