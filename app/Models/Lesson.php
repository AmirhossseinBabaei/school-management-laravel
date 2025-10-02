<?php

namespace App\Models;

use App\Services\JalaliDateServiceStatic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    protected $table = 'lessons';

    protected $fillable = [
        'study_base_id',
        'study_field_id',
        'name'
    ];

    public function study_base(): BelongsTo
    {
        return $this->belongsTo(StudyBase::class);
    }

    public function study_field(): BelongsTo
    {
        return $this->belongsTo(StudyField::class);
    }

    public function getCreatedAtAttribute($value): string
    {
        return JalaliDateServiceStatic::toJalali($value);
    }

    public function getUpdatedAtAttribute($value): string
    {
        return JalaliDateServiceStatic::toJalali($value);
    }
}
