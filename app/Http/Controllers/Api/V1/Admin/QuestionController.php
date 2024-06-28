<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\StoreQuestionRequest;
use App\Http\Requests\Api\V1\Admin\UpdateQuestionRequest;
use App\Http\Resources\V1\Admin\QuestionCollection;
use App\Http\Resources\V1\Admin\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $questions = Question::when($request->search, function ($query) use ($request) {
            $query->search($request->search);
        })->when($request->quiz_id, function ($query) use ($request) {
            $query->where('quiz_id', $request->quiz_id);
        })
            ->paginate($request->input('per_page', 10));

        return new QuestionCollection($questions);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(StoreQuestionRequest $request)
    {
        $validated = $request->validated();

        $question = Question::create([
            'quiz_id' => $validated['quiz_id'],
            'text' => $validated['text'],
        ]);

        if ($request->hasFile('image')) {
            $question->addMediaFromRequest('image')->toMediaCollection('image');
        }

        // Generate ULID for each option's number field
        $options = collect($validated['options'])->map(function ($option) {
            return [
                'number' => Str::ulid()->toString(),
                'text' => $option['text'],
                'correct' => $option['correct'],
            ];
        })->toArray();


        // Handle option images
        foreach ($request->options as $key => $option) {
            if (isset($option['image'])) {
                $optionMedia = $question->addMedia($option['image'])->toMediaCollection('option_images');
                $options[$key]['image_url'] = $optionMedia->getUrl();
            } else {
                $options[$key]['image_url'] = "";
            }
        }

        $question->options = $options;
        $question->save();

        return new QuestionResource($question);
    }

    public function show(Question $question)
    {
        return new QuestionResource($question);
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $validated = $request->validated();

        // Generate ULID for each option's number field
        $options = collect($validated['options'])->map(function ($option) {
            return [
                'number' => Str::ulid()->toString(),
                'text' => $option['text'],
                'correct' => $option['correct'],
            ];
        })->toArray();

        $question->update([
            'text' => $validated['text'],
            'options' => $options,
        ]);

        if ($request->hasFile('image')) {
            $question->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return new QuestionResource($question);
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return response()->ok();
    }
}
