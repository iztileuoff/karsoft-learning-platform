<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\UpdateProfileRequest;
use App\Http\Resources\V1\Admin\UserResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request): UserResource
    {
        return new UserResource($request->user()->load('post', 'school'));
    }

    public function update(UpdateProfileRequest $request): UserResource
    {
        return new UserResource(tap($request->user())->update($request->validated()));
    }
}
