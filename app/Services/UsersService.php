<?php

namespace App\Services;

use App\Repositories\UsersRepository;

class UsersService
{
    protected UsersRepository $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function getNewOwnersByDateOfWeek(): array
    {
        $days = DateService::getDateOfThisWeek();
        $counts = [];

        for ($i = 0; $i < 7; $i++) {
            $count = $this->usersRepository->connection()->whereDate('created_at', '=', $days[$i])->count();

            $counts[] = $count;
        }
        return array_merge([$days], [$counts]);
    }
}
