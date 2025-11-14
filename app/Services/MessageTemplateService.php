<?php

namespace App\Services;

use App\Models\Student;
use App\Models\School;
use App\Services\JalaliDateService;

class MessageTemplateService
{
    protected JalaliDateService $jalaliDateService;

    public function __construct(JalaliDateService $jalaliDateService)
    {
        $this->jalaliDateService = $jalaliDateService;
    }

    /**
     * Replace smart fields in message template
     * 
     * @param string $message
     * @param Student|null $student
     * @param School|null $school
     * @return string
     */
    public function replaceSmartFields(string $message, ?Student $student = null, ?School $school = null): string
    {
        $replacements = [];

        // Date replacement
        $replacements['{تاریخ}'] = $this->jalaliDateService->now('yyyy/MM/dd');
        $replacements['{date}'] = $this->jalaliDateService->now('yyyy/MM/dd');

        // School name replacement
        if ($school) {
            $replacements['{اسم مدرسه}'] = $school->name;
            $replacements['{school_name}'] = $school->name;
        } else {
            $replacements['{اسم مدرسه}'] = '';
            $replacements['{school_name}'] = '';
        }

        // Student-specific replacements
        if ($student && $student->user) {
            $replacements['{نام}'] = $student->user->first_name . ' ' . $student->user->last_name;
            $replacements['{name}'] = $student->user->first_name . ' ' . $student->user->last_name;
            $replacements['{نام_دانش_آموز}'] = $student->user->first_name . ' ' . $student->user->last_name;
            $replacements['{student_name}'] = $student->user->first_name . ' ' . $student->user->last_name;

            if ($student->classRoom) {
                $replacements['{کلاس}'] = $student->classRoom->name;
                $replacements['{class}'] = $student->classRoom->name;
            } else {
                $replacements['{کلاس}'] = '';
                $replacements['{class}'] = '';
            }
        } else {
            $replacements['{نام}'] = '';
            $replacements['{name}'] = '';
            $replacements['{نام_دانش_آموز}'] = '';
            $replacements['{student_name}'] = '';
            $replacements['{کلاس}'] = '';
            $replacements['{class}'] = '';
        }

        // Replace all occurrences
        return str_replace(array_keys($replacements), array_values($replacements), $message);
    }

    /**
     * Get available smart fields
     * 
     * @return array
     */
    public function getAvailableSmartFields(): array
    {
        return [
            '{نام}' => 'نام دانش‌آموز',
            '{کلاس}' => 'نام کلاس',
            '{تاریخ}' => 'تاریخ امروز',
            '{اسم مدرسه}' => 'نام مدرسه',
        ];
    }
}

