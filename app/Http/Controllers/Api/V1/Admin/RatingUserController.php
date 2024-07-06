<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\RatingUserRequest;
use App\Http\Resources\V1\Admin\RatingUserCollection;
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
            ->withCount('tests')
            ->withAvg('tests', 'percent')
            ->orderBy('tests_avg_percent', 'desc')
            ->paginate($request->input('per_page', 30));

        return new RatingUserCollection($users);
    }
}
