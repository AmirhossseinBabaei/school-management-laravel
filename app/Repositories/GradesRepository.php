<?php

namespace App\Repositories;

use App\Models\Grade;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class GradesRepository extends BaseRepository
{
    public function connection(): Builder
    {
        return DB::table('grades');
    }

    public function setModel()
    {
        return Grade::class;
    }

    public function insert($data): bool
    {
        return $this->connection()->insert($data);
    }
}


