<?php

namespace App\Http\Requests\Api\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OptionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'question_id' => ['required', 'integer'],
            'text' => ['required'],
            'correct' => ['boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
