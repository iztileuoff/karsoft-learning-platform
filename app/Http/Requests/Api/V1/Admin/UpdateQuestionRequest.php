<?php

namespace App\Http\Requests\Api\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateQuestionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'quiz_id' => [Rule::exists('quizzes', 'id')],
            'text' => ['string', 'max:1000'],
            'image' => ['nullable', 'image', 'max:2048'],
            'options' => ['nullable', 'array', 'min:4'],
            'options.*.text' => ['required_without:options.*.image_url', 'string', 'max:1000'],
            'options.*.correct' => ['required', 'boolean'],
            'options.*.image_url' => ['nullable', 'string', 'url'],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param Validator $validator
     * @return void
     */
    protected function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $options = $this->input('options');

            if (isset($options)) {
                // Check if only one option is marked as correct
                $correctCount = collect($options)->filter(function ($option) {
                    return $option['correct'] == true;
                })->count();

                if ($correctCount !== 1) {
                    $validator->errors()->add('options', 'There must be exactly one correct option.');
                }
            }
        });
    }

    public function authorize(): bool
    {
        return true;
    }
}
