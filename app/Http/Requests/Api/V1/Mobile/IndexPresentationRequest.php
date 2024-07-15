<?php

namespace App\Http\Requests\Api\V1\Mobile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexPresentationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'degree_id' => ['nullable', Rule::exists('degrees', 'id')],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
