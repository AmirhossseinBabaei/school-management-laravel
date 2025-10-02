<?php

namespace App\Models;

use App\Services\JalaliDateServiceStatic;
use Illuminate\Database\Eloquent\Model;

class NotificationFailed extends Model
{
    protected $table = 'notification_failed';

    protected $fillable = [
        'message',
        'status',
        'phone',
        'exception_message'
    ];

    public function getCreatedAtAttribute($value): string
    {
        return JalaliDateServiceStatic::toJalali($value, 'yyyy/MM/dd HH:mm:ss');
    }

    public function getUpdatedAtAttribute($value): string
    {
        return JalaliDateServiceStatic::toJalali($value, 'yyyy/MM/dd HH:mm:ss');
    }

    public function getStatusAttribute($value)
    {
        if ($value == 'exception') {
            return 'ارور';
        }
    }
}
