<?php

namespace App\Http\Requests\Api\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePresentationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'degree_id' => [Rule::exists('degrees', 'id')],
            'file' => ['file', 'mimes:pdf', 'max:204800'],
            'image' => ['image', 'max:2048'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
