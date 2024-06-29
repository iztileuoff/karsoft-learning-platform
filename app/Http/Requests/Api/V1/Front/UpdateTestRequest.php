<?php

namespace App\Http\Requests\Api\V1\Front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTestRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'questions' => ['required', 'array'],
            'questions.*.id' => ['required', 'integer'],
            'questions.*.option_number' => ['required', 'string'],
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
            'finished_at' => now(),
            'time_spent' => null,
            'correct_questions_count' => null,
            'percent' => null,
            'data_questions' => null
        ]);
    }

    public function authorize(): bool
    {
        return $this->test->finished_at === null;
    }
}
