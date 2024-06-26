<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\QuestionRequest;
use App\Http\Resources\V1\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $questions = Question::paginate($request->input('per_page', 10));

        return QuestionResource::collection($questions);
    }

    public function store(QuestionRequest $request)
    {
        return new QuestionResource(Question::create($request->validated()));
    }

    public function show(Question $question)
    {
        return new QuestionResource($question);
    }

    public function update(QuestionRequest $request, Question $question)
    {
        $question->update($request->validated());

        return new QuestionResource($question);
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return response()->json();
    }
}
