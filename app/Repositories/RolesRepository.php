<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class RolesRepository extends BaseRepository
{
    public function connection(): Builder
    {
        return DB::table('roles');
    }

    protected function setModel()
    {
        return Role::class;
    }

    public function getOneById($id)
    {
        return Role::find($id);
    }
}
