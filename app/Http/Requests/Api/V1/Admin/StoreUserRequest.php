<?php

namespace App\Http\Requests\Api\V1\Admin;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:200'],
            'last_name' => ['required', 'string', 'max:200'],
            'phone' => [
                'required',
                'string',
                'regex:/^998([0-9][012345789]|[0-9][125679]|7[01234569])[0-9]{7}$/',
                Rule::unique('users', 'phone')
            ],
            'password' => ['required', 'string', 'min:8', 'max:64'],
            'region_id' => ['required', Rule::exists('regions', 'id')],
            'district_id' => [
                'required',
                Rule::exists('districts', 'id')->where(function (Builder $query) {
                    $query->where('region_id', $this->region_id);
                })
            ],
            'school_id' => ['required', Rule::exists('schools', 'id')],
            'post_id' => ['required', Rule::exists('posts', 'id')],
            'is_admin' => ['nullable'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'is_admin' => false,
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }
}
