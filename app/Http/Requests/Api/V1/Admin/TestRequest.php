<?php

namespace App\Http\Requests\Api\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TestRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'quiz_id' => ['nullable', 'string'],
            'user_id' => ['nullable', 'integer'],
            'from_date' => ['nullable', 'date_format:Y-m-d'],
            'to_date' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:from_date'],
            'per_page' => ['required', 'integer', 'min:10', 'max:100']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
