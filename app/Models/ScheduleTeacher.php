<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleTeacher extends Model
{
    protected $table = 'schedule_teachers';

    protected $fillable = [
        'teacher_id',
        'class_id',
        'lesson_id',
        'school_id',
        'day_week',
        'start_time',
        'finish_time',
        'mode'
    ];

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
