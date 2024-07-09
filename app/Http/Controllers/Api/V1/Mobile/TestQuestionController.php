<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Mobile\TestQuestionResource;
use App\Models\Test;

class TestQuestionController extends Controller
{
    public function index(Test $test)
    {
        return new TestQuestionResource($test);
    }
}
