<?php

namespace App\Services;

use App\Models\Student;
use App\Models\School;
use App\Models\User;

class NotificationMessageService
{
    protected JalaliDateService $jalaliDateService;

    public function __construct(JalaliDateService $jalaliDateService)
    {
        $this->jalaliDateService = $jalaliDateService;
    }

    /**
     * Replace smart fields in message with actual values
     * 
     * @param string $message
     * @param Student|null $student
     * @param School|null $school
     * @return string
     */
    public function replaceSmartFields(string $message, ?Student $student = null, ?School $school = null): string
    {
        $replacements = [];

        // Get current date
        $replacements['{تاریخ}'] = $this->jalaliDateService->now('yyyy/MM/dd');
        $replacements['{date}'] = $this->jalaliDateService->now('yyyy/MM/dd');

        // School name
        if ($school) {
            $replacements['{اسم مدرسه}'] = $school->name;
            $replacements['{school_name}'] = $school->name;
        } else {
            $replacements['{اسم مدرسه}'] = '';
            $replacements['{school_name}'] = '';
        }

        // Student-specific fields
        if ($student && $student->user) {
            $replacements['{نام}'] = $student->user->first_name . ' ' . $student->user->last_name;
            $replacements['{name}'] = $student->user->first_name . ' ' . $student->user->last_name;
            $replacements['{نام_نام خانوادگی}'] = $student->user->first_name . ' ' . $student->user->last_name;
            
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
            $replacements['{نام_نام خانوادگی}'] = '';
            $replacements['{کلاس}'] = '';
            $replacements['{class}'] = '';
        }

        // Replace all fields
        foreach ($replacements as $field => $value) {
            $message = str_replace($field, $value, $message);
        }

        return $message;
    }

    /**
     * Replace smart fields for multiple students
     * 
     * @param string $message
     * @param array $students Array of Student models
     * @param School|null $school
     * @return array Array of personalized messages
     */
    public function replaceSmartFieldsForMultiple(string $message, array $students, ?School $school = null): array
    {
        $personalizedMessages = [];

        foreach ($students as $student) {
            $personalizedMessages[] = $this->replaceSmartFields($message, $student, $school);
        }

        return $personalizedMessages;
    }
}

