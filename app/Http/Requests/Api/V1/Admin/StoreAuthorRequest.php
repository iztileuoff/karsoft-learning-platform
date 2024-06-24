<?php

namespace App\Http\Requests\Api\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuthorRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable'],
            'description_kaa' => ['required', 'string', 'max:5000'],
            'description_uz' => ['required', 'string', 'max:5000'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'description' => [
                'kaa' => $this->description_kaa,
                'uz' => $this->description_uz,
            ]
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }
}
