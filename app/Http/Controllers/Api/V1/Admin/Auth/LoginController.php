<?php

namespace App\Http\Controllers\Api\V1\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\LoginRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $user = User::where('phone', $request->phone)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'phone' => [__('auth.failed')],
            ]);
        }

        $device = substr($request->userAgent() ?? '', 0, 255);

        return response()->success([
            'user' => new UserResource($user),
            'access_token' => $user->createToken($device)->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }
}
