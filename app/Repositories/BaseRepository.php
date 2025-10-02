<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class BaseRepository implements RepositoryInterface
{
    public function connection(): Builder
    {
        return DB::table('');
    }

    protected function setModel()
    {

    }

    public function store(array $data)
    {
        return $this->setModel()::create($data);
    }

    public function getOneById($id)
    {
        return $this->connection()->where('id', $id)->first();
    }

    public function all()
    {
        return $this->connection()->orderBy('id', 'desc')->get();
    }

    public function update($id, $data)
    {
        return $this->connection()->where('id', $id)->update($data);
    }

    public function destroy($id): bool
    {
        return $this->connection()->where('id', $id)->delete();
    }

    public function count()
    {
        return $this->connection()->pluck('id')->count();
    }

    public function getAllByPaginate()
    {
        return $this->setModel()::orderBy('id', 'desc')->paginate(10);
    }
}
