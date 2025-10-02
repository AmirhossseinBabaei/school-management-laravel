<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class CreateStudentsRequest extends FormRequest
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
            'school_id' => 'required|exists:schools,id',
            'user_id' => 'required|exists:users,id',
            'study_field_id' => 'required|exists:study_fields,id',
            'study_base_id' => 'required|exists:study_bases,id',
            'class_id' => 'required|exists:classes,id'
        ];
    }
}
