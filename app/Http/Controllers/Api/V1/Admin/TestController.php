<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\TestRequest;
use App\Http\Resources\V1\Front\TestResource;
use App\Models\Test;

class TestController extends Controller
{
    public function index()
    {
        return TestResource::collection(Test::all());
    }

    public function show(Test $test)
    {
        return new TestResource($test);
    }
}
