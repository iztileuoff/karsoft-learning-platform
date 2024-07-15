<?php

namespace App\Http\Requests\Api\V1\Mobile;

use App\Enums\LanguagesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexTextbookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'degree_id' => ['nullable', Rule::exists('degrees', 'id')],
            'language' => ['nullable', Rule::enum(LanguagesEnum::class)],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
