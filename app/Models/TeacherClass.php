<?php

namespace App\Models;

use App\Services\JalaliDateServiceStatic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherClass extends Model
{
    protected $table = 'teacher_classes';

    protected $fillable = [
        'school_id',
        'lesson_id',
        'teacher_id',
        'class_id'
    ];

    public function getCreatedAtAttribute($value): string
    {
        return JalaliDateServiceStatic::toJalali($value);
    }

    public function getUpdatedAtAttribute($value): string
    {
        return JalaliDateServiceStatic::toJalali($value);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(classRoom::class, 'class_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
