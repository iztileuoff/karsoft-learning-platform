<?php

namespace App\Http\Requests\Api\V1\Front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTestRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'answers' => ['required', 'array'],
            'answers.*.question_id' => ['required', 'integer', function ($attribute, $value, $fail) {
                $questionIds = array_column($this->test->data_questions, 'id');

                if (!in_array($value, $questionIds)) {
                    return $fail("Invalid question ID: {$value}");
                }
            }],
            'answers.*.option_number' => ['required', 'string', function ($attribute, $value, $fail) {
                $questionIndex = explode('.', $attribute)[1];
                $questionId = $this->input("answers.$questionIndex.question_id");

                $question = collect($this->test->data_questions)->firstWhere('id', $questionId);

                $questionIds = array_column($this->test->data_questions, 'id');

                if (!in_array($question->id, $questionIds)) {
                    return $fail("Invalid question ID: {$question->id}");
                }

                $optionIds = array_column($question['options'], 'number');

                if (!in_array($value, $optionIds)) {
                    return $fail("Invalid option NUMBER: {$value}");
                }
            }],
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
