<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Mobile\QuestionRequest;
use App\Http\Resources\V1\Mobile\TestQuestionResource;
use App\Models\Test;

class QuestionController extends Controller
{
    public function index(QuestionRequest $request)
    {
        $test = Test::find($request->input('test_id'));

        return new TestQuestionResource($test);
    }
}
