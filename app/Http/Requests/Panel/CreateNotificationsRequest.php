<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class CreateNotificationsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'message' => 'required|max:1000',
            'audience_data' => 'required|in:allUsers,allOwners,attendanceSchool,student,parent,multipleStudents,class,studyBase,allTeachers,allSchool,allSchoolStudents,absentStudents,debtStudents,lowGradeStudents',
            'role_id' => 'nullable|exists:roles,id',
            'school_id' => 'nullable|exists:schools,id',
            'student_id' => 'nullable|exists:students,id',
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'exists:students,id',
            'class_id' => 'nullable|exists:classes,id',
            'study_base_id' => 'nullable|exists:study_bases,id',
            'min_grade' => 'nullable|numeric|min:0|max:20',
            'template_id' => 'nullable|string',
            'channels.*' => 'required|in:sms'
        ];
    }
}
