<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Mobile\UpdateProfileRequest;
use App\Http\Resources\V1\Mobile\UserResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request): UserResource
    {
        return new UserResource(
            $request->user()
                ->load('post', 'school', 'district', 'region')
        );
    }

    public function update(UpdateProfileRequest $request): UserResource
    {
        return new UserResource(tap($request->user())->update($request->validated()));
    }

    public function destroy(Request $request)
    {
        $request->user()->tokens()->delete();
        $request->user()->delete();

        return response()->ok();
    }
}
