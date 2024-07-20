<?php

namespace App\Http\Requests\Api\V1\Front;

use Illuminate\Foundation\Http\FormRequest;

class IndexRatingTestRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'quiz_id' => ['nullable', 'string'],
            'from_date' => ['nullable', 'date_format:Y-m-d'],
            'to_date' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:from_date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
