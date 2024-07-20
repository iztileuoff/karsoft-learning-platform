<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Front\IndexRatingTestRequest;
use App\Http\Resources\V1\Front\TestCollection;
use App\Models\Test;

class RatingTestController extends Controller
{
    public function index(IndexRatingTestRequest $request)
    {
        $tests = Test::when($request->quiz_id, function ($query) use ($request) {
            $query->where('quiz_id', $request->quiz_id);
        })->when($request->from_date, function ($query) use ($request) {
            $query->whereDate('started_at', '>=', $request->from_date);
        })->when($request->to_date, function ($query) use ($request) {
            $query->whereDate('started_at', '<=', $request->to_date);
        })
            ->select([
                'id',
                'quiz_id',
                'user_id',
                'started_at',
                'finished_at',
                'time_spent',
                'questions_count',
                'correct_answers_count',
                'percent'
            ])
            ->with(
                'quiz',
                'user:id,first_name,last_name,post_id,school_id',
                'user.post:id,name',
                'user.school:id,district_id,name',
                'user.school.district:id,name',
            )
            ->orderBy('percent', 'desc')
            ->cursorPaginate(30);

        return new TestCollection($tests);
    }
}
