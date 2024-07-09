<?php

namespace App\Http\Controllers\Api\V1\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Front\TestAnswerRequest;
use App\Http\Resources\V1\Front\TestAnswerResource;
use App\Models\Test;

class TestAnswerController extends Controller
{
    public function index(TestAnswerRequest $request, Test $test)
    {
        return new TestAnswerResource($test);
    }
}
