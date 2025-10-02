<?php

namespace App\Repositories;

use App\Models\Notification;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class NotificationsRepository extends BaseRepository
{
    public function connection(): Builder
    {
        return DB::table('notifications');
    }

    public function setModel(): string
    {
        return Notification::class;
    }
}
