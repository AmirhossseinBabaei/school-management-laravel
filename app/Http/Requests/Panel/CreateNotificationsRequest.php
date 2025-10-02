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
            'message' => 'required|max:100',
            'audience_data' => 'required|in:allUsers,allOwners,attendanceSchool,student',
            'role_id' => 'exists:roles,id',
            'school_id' => 'exists:schools,id',
            'student_id' => 'exists:students,id',
            'channels.*' => 'required|in:sms'
        ];
    }
}
