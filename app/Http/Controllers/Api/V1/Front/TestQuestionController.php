<?php

namespace App\Http\Controllers\Api\V1\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Front\TestQuestionResource;
use App\Models\Test;

class TestQuestionController extends Controller
{
    public function index(Test $test)
    {
        return new TestQuestionResource($test);
    }
}
