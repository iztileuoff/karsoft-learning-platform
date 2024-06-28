<?php

namespace App\Http\Requests\Api\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TestRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'quiz_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'started_at' => ['nullable', 'date'],
            'finished_at' => ['nullable', 'date'],
            'time_spent' => ['nullable', 'integer'],
            'questions_count' => ['nullable', 'integer'],
            'correct_questions_count' => ['nullable', 'integer'],
            'data_questions' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
