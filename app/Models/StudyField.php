<?php

namespace App\Models;

use App\Services\JalaliDateServiceStatic;
use Illuminate\Database\Eloquent\Model;

class StudyField extends Model
{
    protected $table = 'study_fields';

    public function getCreatedAtAttribute($value)
    {
        return JalaliDateServiceStatic::toJalali($value, 'yyyy/MM/dd HH:mm:ss');
    }

    public function getUpdatedAtAttribute($value)
    {
        return JalaliDateServiceStatic::toJalali($value, 'yyyy/MM/dd HH:mm:ss');
    }

    public function studyBase()
    {
        return $this->belongsTo(StudyBase::class);
    }

    public function parent()
    {
        return $this->belongsTo(StudyField::class);
    }
}
