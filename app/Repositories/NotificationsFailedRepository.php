<?php

namespace App\Repositories;

use App\Models\NotificationFailed;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class NotificationsFailedRepository extends BaseRepository
{
    public function connection(): Builder
    {
        return DB::table('notification_failed');
    }

    public function setModel(): string
    {
        return NotificationFailed::class;
    }

    public function getOneById($id)
    {
        return $this->setModel()::find($id);
    }
}
