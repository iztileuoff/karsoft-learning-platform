<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\TestRequest;
use App\Http\Resources\V1\Admin\TestCollection;
use App\Http\Resources\V1\Admin\TestResource;
use App\Models\Test;

class TestController extends Controller
{
    public function index(TestRequest $request)
    {
        $tests = Test::when($request->quiz_id, function ($query) use ($request) {
            $query->where('quiz_id', $request->quiz_id);
        })->when($request->user_id, function ($query) use ($request) {
            $query->where('user_id', $request->user_id);
        })->when($request->from_date, function ($query) use ($request) {
            $query->whereDate('started_at', '>=', $request->from_date);
        })->when($request->to_date, function ($query) use ($request) {
            $query->whereDate('started_at', '<=', $request->to_date);
        })
            ->with('quiz', 'user')
            ->select('quiz_id', 'user_id', 'started_at', 'finished_at', 'time_spent', 'questions_count', 'correct_answers_count', 'percent')
            ->paginate($request->input('per_page', 10));

        return new TestCollection($tests);
    }

    public function show(Test $test)
    {
        return new TestResource($test->load('quiz', 'user'));
    }
}
