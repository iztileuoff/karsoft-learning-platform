<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\StoreUserRequest;
use App\Http\Requests\Api\V1\Admin\UpdateUserRequest;
use App\Http\Resources\V1\Admin\UserCollection;
use App\Http\Resources\V1\Admin\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(Request $request): UserCollection
    {
        $users = User::where('is_admin', false)
            ->with('post', 'school', 'district', 'region')
            ->paginate($request->input('per_page', 10));

        return new UserCollection($users);
    }

    public function store(StoreUserRequest $request): UserResource
    {
        return new UserResource(User::create($request->validated()));
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user->load('post', 'school', 'district', 'region'));
    }

    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        return new UserResource(tap($user)->update($request->validated()));
    }

    public function destroy(User $user): JsonResponse
    {
        if ($user->id == 34) {
            throw ValidationException::withMessages([
                'message' => "You can't delete google user.",
            ]);
        }

        $user->delete();

        return response()->ok();
    }
}
