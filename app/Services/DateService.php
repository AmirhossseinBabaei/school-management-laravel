<?php

namespace App\Services;

use App\Repositories\UsersRepository;
use Illuminate\Support\Carbon;

class DateService
{
    public static function getDateOfThisWeek(): array
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $sevenDayBeforeDate = Carbon::now()->subDays(7)->toDateString();

        $days = [];

        for ($i=0; $i<7; $i++) {
            $days[] = Carbon::now()->subDays($i)->toDateString();
        }

        return $days;
    }
}
