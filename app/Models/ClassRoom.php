<?php

namespace App\Models;

use App\Services\JalaliDateServiceStatic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassRoom extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'school_id',
        'name',
        'study_base_id',
        'study_field_id'
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function studyBase(): BelongsTo
    {
        return $this->belongsTo(StudyBase::class);
    }

    public function studyField(): BelongsTo
    {
        return $this->belongsTo(StudyField::class);
    }

    public function getCreatedAtAttribute($value): string
    {
        return JalaliDateServiceStatic::toJalali($value, 'yyyy/MM/dd HH:mm:ss');
    }

    public function getUpdatedAtAttribute($value): string
    {
        return JalaliDateServiceStatic::toJalali($value, 'yyyy/MM/dd HH:mm:ss');
    }
}
