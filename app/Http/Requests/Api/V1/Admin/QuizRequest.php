<?php

namespace App\Http\Requests\Api\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;

class QuizRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'description' => ['required'],
            'degree_id' => ['required', 'integer'],
            'language' => ['required'],
            'number_of_questions' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
