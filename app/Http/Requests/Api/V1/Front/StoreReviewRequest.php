<?php

namespace App\Http\Requests\Api\V1\Front;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'text' => ['required', 'string', 'max:5000'],
            'creator_id' => ['nullable']
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
