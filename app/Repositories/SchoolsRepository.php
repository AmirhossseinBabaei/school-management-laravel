<?php

namespace App\Repositories;

use App\Models\School;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class SchoolsRepository extends BaseRepository
{
    public function connection(): Builder
    {
        return DB::table('schools');
    }

    public function setModel()
    {
        return School::class;
    }

    public function lastRecord()
    {
        return $this->connection()->orderBy('created_at', 'asc')->first();
    }

    public function getOneById($id)
    {
        return $this->setModel()::find($id);
    }
}
