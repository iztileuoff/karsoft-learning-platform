<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\QuizRequest;
use App\Http\Resources\V1\QuizResource;
use App\Models\Quiz;

class QuizController extends Controller
{
    public function index()
    {
        return QuizResource::collection(Quiz::all());
    }

    public function store(QuizRequest $request)
    {
        return new QuizResource(Quiz::create($request->validated()));
    }

    public function show(Quiz $quiz)
    {
        return new QuizResource($quiz);
    }

    public function update(QuizRequest $request, Quiz $quiz)
    {
        $quiz->update($request->validated());

        return new QuizResource($quiz);
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return response()->json();
    }
}
