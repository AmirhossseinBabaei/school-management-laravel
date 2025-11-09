<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateGradeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
//            'class_id' => ['required','integer','exists:class_rooms,id'],
//            'lesson_id' => ['required','integer','exists:lessons,id'],
//            'term_id' => ['required','integer','exists:terms,id'],
//            'students' => ['required','array','min:1'],
//            'students.*.student_id' => ['required','integer','exists:students,id'],
//            'students.*.score' => ['required','numeric','between:0,20'],
//            'students.*.description' => ['nullable','string','max:255'],
        ];
    }
}


