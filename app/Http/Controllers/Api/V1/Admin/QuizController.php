<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\QuizRequest;
use App\Http\Resources\V1\Admin\QuizCollection;
use App\Http\Resources\V1\Admin\QuizResource;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Request $request): QuizCollection
    {
        $quizzes = Quiz::with('degree')
            ->withCount('questions')
            ->paginate($request->input('per_page', 10));

        return new QuizCollection($quizzes);
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
