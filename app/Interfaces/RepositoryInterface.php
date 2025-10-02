<?php

namespace App\Interfaces;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function store(array $data);

    public function getOneById($id);

    public function all();

    public function destroy ($id): bool;

    public function count();
}
