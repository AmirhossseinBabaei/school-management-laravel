<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
        $studentId = $this->route('student');
        
        return [
            'student_number' => 'required|string|max:50|unique:students,student_number,' . $studentId,
            'user_id' => 'required|exists:users,id',
            'school_id' => 'required|exists:schools,id',
            'enrollment_date' => 'required|date',
            'grade' => 'required|string|max:50',
            'class_name' => 'nullable|string|max:100',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'student_number.required' => 'شماره دانش‌آموزی الزامی است',
            'student_number.unique' => 'این شماره دانش‌آموزی قبلاً ثبت شده است',
            'user_id.required' => 'انتخاب کاربر الزامی است',
            'user_id.exists' => 'کاربر انتخاب شده وجود ندارد',
            'school_id.required' => 'انتخاب مدرسه الزامی است',
            'school_id.exists' => 'مدرسه انتخاب شده وجود ندارد',
            'enrollment_date.required' => 'تاریخ ثبت‌نام الزامی است',
            'enrollment_date.date' => 'تاریخ ثبت‌نام باید معتبر باشد',
            'grade.required' => 'پایه تحصیلی الزامی است',
        ];
    }
}




