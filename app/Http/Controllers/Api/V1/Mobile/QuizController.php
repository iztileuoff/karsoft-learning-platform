<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Mobile\QuizCollection;
use App\Http\Resources\V1\Mobile\QuizResource;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $quizzes = Quiz::with('degree', 'test')
            ->withCount('questions')
            ->paginate($request->input('per_page', 10));

        return new QuizCollection($quizzes);
    }

    public function show(Quiz $quiz)
    {
        return new QuizResource($quiz->load('degree', 'test'));
    }
}
