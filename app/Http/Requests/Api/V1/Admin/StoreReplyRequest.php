<?php

namespace App\Http\Requests\Api\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReplyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'review_id' => ['required', Rule::exists('reviews', 'id'), Rule::unique('replies', 'review_id')],
            'text' => ['required', 'string', 'max:5000'],
            'creator_id' => ['nullable'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'creator_id' => $this->user()->id,
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }
}
