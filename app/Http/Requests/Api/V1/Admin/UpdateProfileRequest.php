<?php

namespace App\Http\Requests\Api\V1\Admin;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['string', 'max:200'],
            'last_name' => ['string', 'max:200'],
            'phone' => ['string', 'regex:/^998([0-9][012345789]|[0-9][125679]|7[01234569])[0-9]{7}$/', Rule::unique('users', 'phone')->ignore($this->user())],
            'password' => ['string', 'min:8', 'max:64'],
            'post_id' => [Rule::exists('posts', 'id')],
            'district_id' => ['required_with:school_id', Rule::exists('districts', 'id')],
            'school_id' => [Rule::exists('schools', 'id')->where(function (Builder $query) {
                $query->where('district_id', $this->district_id);
            })],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
