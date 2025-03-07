<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Mobile\StoreTestRequest;
use App\Http\Requests\Api\V1\Mobile\UpdateTestRequest;
use App\Http\Resources\V1\Mobile\QuestionResource;
use App\Http\Resources\V1\Mobile\TestResource;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Test;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class TestController extends Controller
{
    public function store(StoreTestRequest $request)
    {
        $validated = $request->validated();

        $quiz = Quiz::find($validated['quiz_id']);

        $randomQuestions = Question::where('quiz_id', $quiz->id)->inRandomOrder()->limit(
            $quiz->number_of_questions
        )->get();
        $randomQuestionsCount = $randomQuestions->count();
        $dataQuestions = QuestionResource::collection($randomQuestions);

        if ($randomQuestionsCount == 0) {
            throw ValidationException::withMessages([
                'quiz' => 'Bul testke sorawlar tolıq qosılmadı.',
            ]);
        }

        $validated['questions_count'] = $randomQuestionsCount;
        $validated['data_questions'] = $dataQuestions;

        $test = Test::firstOrCreate([
            'quiz_id' => $validated['quiz_id'],
            'user_id' => $validated['user_id'],
        ]);

        $test->update($validated);

        return new TestResource($test);
    }

    public function show(Test $test)
    {
        Gate::authorize('view', $test);

        return new TestResource($test->load('quiz', 'user'));
    }

    public function update(UpdateTestRequest $request, Test $test)
    {
        Gate::authorize('update', $test);

        $validated = $request->validated();
        $answers = collect($validated['answers']);
        $dataQuestions = collect($test->data_questions);

        $answersCount = $answers->count();
        $dataQuestionsCount = $dataQuestions->count();

        if ($answersCount != $dataQuestionsCount) {
            throw ValidationException::withMessages([
                'questions' => 'Please, send all questions. Questions count must be: ' . $dataQuestionsCount
            ]);
        }

        $answeredQuestions = [];

        foreach ($answers as $answer) {
            $dataQuestion = $dataQuestions->where('id', $answer['question_id'])->first();

            $options = collect($dataQuestion['options']);

            $dataQuestion['correct_option'] = $options->where('correct', true)->first();

            $options = $options->map(function ($option) use ($answer) {
                return [
                    'number' => $option['number'],
                    'text' => $option['text'],
                    'correct' => $option['correct'],
                    'image_url' => $option['image_url'],
                    'is_selected' => $answer['option_number'] == $option['number'],
                ];
            });

            $dataQuestion['options'] = $options->toArray();
            $dataQuestion['correct_answer'] = $options->where('correct', true)->where('is_selected', true)->count() > 0;

            $answeredQuestions[] = $dataQuestion;
        }

        $started_at = $test->started_at;
        $finished_at = Carbon::parse($validated['finished_at']);

        $validated['data_questions'] = $answeredQuestions;
        $validated['time_spent'] = $started_at->diffInSeconds($finished_at);
        $validated['correct_answers_count'] = collect($answeredQuestions)->where('correct_answer', true)->count();
        $validated['percent'] = (100 * $validated['correct_answers_count']) / $dataQuestionsCount;

        $test->update($validated);

        return new TestResource($test);
    }
}
