<?php

namespace App\Actions\Mobile;

use App\Http\Requests\Api\V1\Mobile\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginUser
{
    public function execute(LoginRequest $request): array
    {
        $user = User::where('phone', $request->phone)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'phone' => [__('auth.failed')],
            ]);
        }

        $device = substr($request->userAgent() ?? '', 0, 255);

        return [$user->load('post', 'school'), $user->createToken($device)->plainTextToken];
    }
}
