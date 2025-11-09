<?php

namespace App\Repositories;

use App\Models\DisciplinaryRecord;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class DisciplinaryRecordsRepository extends BaseRepository
{
    public function connection(): Builder
    {
        return DB::table('disciplinary_records');
    }

    public function setModel()
    {
        return DisciplinaryRecord::class;
    }
}


