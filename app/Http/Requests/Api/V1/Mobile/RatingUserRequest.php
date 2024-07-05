<?php

namespace App\Http\Requests\Api\V1\Mobile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RatingUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'post_id' => ['required', Rule::exists('posts', 'id')],
            'per_page' => ['required', 'integer', 'min:10', 'max:100'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
