<?php

namespace App\Http\Controllers\Api\V1\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Front\StoreTestRequest;
use App\Http\Requests\Api\V1\Front\TestRequest;
use App\Http\Requests\Api\V1\Front\UpdateTestRequest;
use App\Http\Resources\V1\Front\QuestionResource;
use App\Http\Resources\V1\Front\TestCollection;
use App\Http\Resources\V1\Front\TestResource;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Test;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class TestController extends Controller
{
    public function index(TestRequest $request)
    {
        $tests = Test::where('user_id', $request->user()->id)
            ->when($request->quiz_id, function ($query) use ($request) {
                $query->where('quiz_id', $request->quiz_id);
            })->when($request->from_date, function ($query) use ($request) {
                $query->whereDate('started_at', '>=', $request->from_date);
            })->when($request->to_date, function ($query) use ($request) {
                $query->whereDate('started_at', '<=', $request->to_date);
            })
                ->with('quiz')
                ->select('id', 'quiz_id', 'user_id', 'started_at', 'finished_at', 'time_spent', 'questions_count', 'correct_questions_count', 'percent')
                ->paginate($request->input('per_page', 10));

        return new TestCollection($tests);
    }

    public function store(StoreTestRequest $request)
    {
        $validated = $request->validated();

        $quiz = Quiz::find($validated['quiz_id']);

        $randomQuestions = Question::where('quiz_id', $quiz->id)->inRandomOrder()->limit($quiz->questions_count)->get();
        $dataQuestions = QuestionResource::collection($randomQuestions);

        $validated['questions_count'] = $quiz->questions_count;
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

        $quiz = Quiz::find($test->quiz_id);

        $validated = $request->validated();
        $questions = collect($validated['questions']);
        $dataQuestions = collect($test->data_questions);

        $questionsCount = $questions->count();
        $dataQuestionsCount = $dataQuestions->count();

        if ($questionsCount != $dataQuestionsCount) {
            throw ValidationException::withMessages([
                'questions' => 'Please, send all questions. Questions count must be: ' . $dataQuestionsCount
            ]);
        }

        $answeredQuestions = [];

        foreach ($questions as $question) {
            $dataQuestion = $dataQuestions->where('id', $question['id'])->first();

            $options = collect($dataQuestion['options']);

            $dataQuestion['correct_option'] = $options->where('correct', true)->first();

            $options = $options->map(function ($option) use ($question) {
                return [
                    'number' => $option['number'],
                    'text' => $option['text'],
                    'correct' => $option['correct'],
                    'image_url' => $option['image_url'],
                    'is_selected' => $question['option_number'] == $option['number'],
                ];
            });

            $dataQuestion['options'] = $options->toArray();
            $dataQuestion['correct_answer'] = $options->where('correct', true)->where('is_selected', true)->count() > 0;

            $answeredQuestions[] = $dataQuestion;
        }

        $started_at = $test->started_at;
        $finished_at = Carbon::parse($validated['finished_at']);

        $validated['data_questions'] = $answeredQuestions;
        $validated['time_spent'] = $started_at->diffInMinutes($finished_at);
        $validated['correct_questions_count'] = collect($answeredQuestions)->where('correct_answer', true)->count();
        $validated['percent'] = (100 * $validated['correct_questions_count']) / $dataQuestionsCount;

        $test->update($validated);

        return new TestResource($test->load('quiz', 'user'));
    }
}
