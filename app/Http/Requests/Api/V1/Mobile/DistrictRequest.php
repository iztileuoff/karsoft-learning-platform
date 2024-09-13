<?php

namespace App\Http\Requests\Api\V1\Mobile;

use Illuminate\Foundation\Http\FormRequest;

class DistrictRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'region_id' => ['required', 'int'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
