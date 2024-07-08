<?php

namespace App\Http\Requests\Api\V1\Mobile;

use App\Enums\DistrictsEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SchoolRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'district_id' => ['required', 'int', Rule::enum(DistrictsEnum::class)],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
