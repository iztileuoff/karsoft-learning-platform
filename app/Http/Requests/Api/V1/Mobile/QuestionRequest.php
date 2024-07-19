<?php

namespace App\Http\Requests\Api\V1\Mobile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuestionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'test_id' => [
                'required',
                Rule::exists('tests', 'id')->where(function ($query) {
                    $query->where('user_id', $this->user()->id);
                }),
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
