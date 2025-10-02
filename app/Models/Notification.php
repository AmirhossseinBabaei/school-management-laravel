<?php

namespace App\Models;

use App\Services\JalaliDateServiceStatic;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'title',
        'message',
        'audience_data',
        'channels',
        'status',
        'schedule_at'
    ];

    public function getCreatedAtAttribute($value): string
    {
        return JalaliDateServiceStatic::toJalali($value);
    }

    public function getUpdatedAtAttribute($value): string
    {
        return JalaliDateServiceStatic::toJalali($value);
    }

    public function getStatusAttribute($value): string
    {
        if ($value == 'send'){
            return 'ارسال شده';
        }
        else if ($value == 'exception') {
            return 'ارور';
        }
        else if ($value == 'queue')
        {
            return 'در صف ارسال';
        }
        else{
            return '';
        }
    }

    public function getAudienceDataAttribute($value): string
    {
        if ($value == 'student'){
            return 'دانش آموز';
        }
        else if ($value == 'allUsers') {
            return 'کل کاربران سیستم';
        }
        else if ($value == 'allOwners')
        {
            return 'کل مدیران سیستم';
        }
        else if ($value == 'attendanceSchool') {
            return 'غایبان مدرسه';
        }
        else{
            return '';
        }
    }
}
