<?php

namespace App\Http\Requests\Api\V1\Admin;

use App\Enums\LanguagesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTextbookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string', 'max:5000'],
            'degree_id' => ['required', Rule::exists('degrees', 'id')],
            'language' => ['required', Rule::enum(LanguagesEnum::class)],
            'file' => ['required', 'file', 'mimes:pdf', 'max:204800'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
