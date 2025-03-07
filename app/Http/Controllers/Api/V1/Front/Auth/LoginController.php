<?php

namespace App\Http\Controllers\Api\V1\Front\Auth;

use App\Actions\Front\LoginUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Front\LoginRequest;
use App\Http\Resources\V1\Front\UserResource;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request, LoginUser $action): JsonResponse
    {
        [$user, $accessToken] = $action->execute($request);

        return response()->success([
            'user' => new UserResource($user),
            'access_token' => $accessToken,
            'token_type' => 'Bearer',
        ]);
    }
}
