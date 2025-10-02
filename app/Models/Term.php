<?php

namespace App\Models;

use App\Services\JalaliDateServiceStatic;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function getFromDateAttribute($value)
    {
        return JalaliDateServiceStatic::toJalali($value, 'yyyy/MM/dd');
    }

    public function getToDateAttribute($value)
    {
        return JalaliDateServiceStatic::toJalali($value, 'yyyy/MM/dd');
    }

    public function getCreatedAtAttribute($value)
    {
        return JalaliDateServiceStatic::toJalali($value);
    }
    public function getUpdatedAtAttribute($value)
    {
        return JalaliDateServiceStatic::toJalali($value);
    }
}
