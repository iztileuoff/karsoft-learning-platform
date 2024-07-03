<?php

namespace App\Http\Controllers\Api\V1\Mobile\Auth;

use App\Actions\Mobile\LoginUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Mobile\LoginRequest;
use App\Http\Resources\V1\Mobile\UserResource;
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
