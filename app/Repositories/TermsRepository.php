<?php

namespace App\Repositories;

use App\Models\Term;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class TermsRepository extends BaseRepository
{
    public function connection(): Builder
    {
        return DB::table('terms');
    }

    protected function setModel()
    {
        return Term::class;
    }

    public function getAllByPaginateAndWithSchools()
    {
        return $this->setModel()::with('school')->orderBy('id', 'desc')->paginate(10);
    }

    public function getOneById($id)
    {
        return Term::find($id);
    }
}
