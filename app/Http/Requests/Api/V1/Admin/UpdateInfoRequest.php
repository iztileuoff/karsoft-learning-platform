<?php

namespace App\Http\Requests\Api\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInfoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'text' => ['nullable'],
            'text_kaa' => ['required', 'string', 'max:5000'],
            'text_uz' => ['required', 'string', 'max:5000'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'text' => [
                'kaa' => $this->text_kaa,
                'uz' => $this->text_uz,
            ]
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }
}
