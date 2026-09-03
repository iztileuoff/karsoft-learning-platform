<?php

namespace App\Http\Requests\Api\V1\Front;

use Illuminate\Foundation\Http\FormRequest;

class UploadAttachmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'max:10240',
                'mimes:jpg,jpeg,png,gif,webp,pdf,txt,doc,docx',
            ],
        ];
    }
}
