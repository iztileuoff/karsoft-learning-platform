<?php

namespace App\Http\Requests\Api\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:200'],
            'video' => ['file', 'mimes:mp4', 'max:204800'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
