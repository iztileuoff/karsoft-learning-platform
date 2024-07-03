<?php

namespace App\Http\Requests\Api\V1\Mobile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTestRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'quiz_id' => ['required', 'string', Rule::exists('quizzes', 'id')],
            'user_id' => ['nullable'],
            'started_at' => ['nullable'],
            'finished_at' => ['nullable'],
            'time_spent' => ['nullable'],
            'questions_count' => ['nullable'],
            'correct_questions_count' => ['nullable'],
            'percent' => ['nullable'],
            'data_questions' => ['nullable'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => $this->user()->id,
            'started_at' => now(),
            'finished_at' => null,
            'time_spent' => null,
            'questions_count' => 0,
            'correct_questions_count' => null,
            'percent' => null,
            'data_questions' => null
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }
}
