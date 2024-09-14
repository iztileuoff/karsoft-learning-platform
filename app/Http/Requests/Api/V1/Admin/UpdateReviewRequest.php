<?php

namespace App\Http\Requests\Api\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'text' => ['string', 'max:5000'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
