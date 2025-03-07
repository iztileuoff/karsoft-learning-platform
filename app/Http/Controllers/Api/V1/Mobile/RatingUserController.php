<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Mobile\RatingUserRequest;
use App\Http\Resources\V1\Mobile\RatingUserCollection;
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
            ->orderBy('tests_avg_percent', 'desc')
            ->cursorPaginate(30);

        return new RatingUserCollection($users);
    }
}
