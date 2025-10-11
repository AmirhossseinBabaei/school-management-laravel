<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $table = 'attendances';

    protected $fillable = [
        'school_id',
        'student_id',
        'class_id',
        'lesson_id',
        'status',
        'attendance_by_user_id',
        'attended_at',
        'description',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'attended_at' => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function attendanceByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'attendance_by_user_id');
    }
}
