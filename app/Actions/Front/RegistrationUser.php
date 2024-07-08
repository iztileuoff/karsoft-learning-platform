<?php

namespace App\Actions\Front;

use App\Http\Requests\Api\V1\Front\RegistrationRequest;
use App\Models\User;

class RegistrationUser
{
    public function execute(RegistrationRequest $request): array
    {
        $user = User::create($request->validated());

        $device = substr($request->userAgent() ?? '', 0, 255);

        return [$user->load('post', 'school'), $user->createToken($device, ['front'])->plainTextToken];
    }
}
