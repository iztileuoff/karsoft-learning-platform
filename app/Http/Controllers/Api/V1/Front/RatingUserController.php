<?php

namespace App\Http\Controllers\Api\V1\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Front\RatingUserRequest;
use App\Http\Resources\V1\Front\RatingUserCollection;
use App\Models\User;

class RatingUserController extends Controller
{
    public function index(RatingUserRequest $request): RatingUserCollection
    {
        $users = User::where('is_admin', false)
            ->when($request->post_id, function ($query) use ($request) {
                $query->where('post_id', $request->post_id);
            })
            ->with('post', 'school')
            ->withAvg('tests', 'percent')
            ->paginate($request->input('per_page', 30));

        return new RatingUserCollection($users);
    }
}
