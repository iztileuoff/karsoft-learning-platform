<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Mobile\AnswerRequest;
use App\Http\Resources\V1\Front\TestAnswerResource;
use App\Models\Test;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AnswerController extends Controller
{
    public function index(AnswerRequest $request)
    {
        $test = Test::find($request->input('test_id'));

        if ($test->finished_at != null) {
            throw new AccessDeniedHttpException();
        }

        return new TestAnswerResource($test);
    }
}
