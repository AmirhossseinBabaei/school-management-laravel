<?php

namespace App\Models;

use App\Services\JalaliDateServiceStatic;
use Illuminate\Database\Eloquent\Model;

class StudyBase extends Model
{
    protected $table = 'study_bases';

    public function getCreatedAtAttribute($value)
    {
        return JalaliDateServiceStatic::toJalali($value, "yyyy/MM/dd HH:mm:ss");
    }

    public function getUpdatedAtAttribute($value)
    {
        return JalaliDateServiceStatic::toJalali($value, "yyyy/MM/dd HH:mm:ss");
    }
}
