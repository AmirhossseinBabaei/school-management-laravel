<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDisciplinaryRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'national_code' => ['required','string'],
            'lesson_id' => ['nullable','integer','exists:lessons,id'],
            'description' => ['nullable','string','max:2000'],
            'severity' => ['required','in:Complete-Homework,Maintain-Order,Respect-the-Teacher,Help-Classmates,Be-Punctual,Take-Care-of-School-Property,Take-Turns,Speak-Honestly,Cooperate-in-Group-Work,Keep-Clean-and-Neat,Participate-Actively-in-Class,Be-Kind-to-Others,Follow-School-Rules,Listen-to-the-Teacher,Keep-Silent-in-Class,Respect-Elders,Fulfill-Assigned-Duty,Use-Polite-Language,Encourage-Others-to-Study,Use-Learning-Materials-Properly,Being-Late,Not-Doing-Homework,Disrespecting-the-Teacher,Fighting-with-Classmates,Being-Disorganized-in-Class,Leaving-Class-Without-Permission,Cheating-on-Exam,Making-Noise-in-Class,Damaging-Property,Mocking-Others,Lying,Using-Rude-Language,Ignoring-the-Lesson,Throwing-Objects-in-Class,Leaving-Without-Coordination,Bullying-Classmates,Forgetting-School-Supplies,Disobeying-Rules,Eating-in-Class,Ignoring-Teachers-Warning'],
            'type' => ['required','in:positive,negative'],
            'score' => ['nullable','numeric','between:0,20'],
        ];
    }
}


