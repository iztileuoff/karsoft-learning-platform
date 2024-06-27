<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\StoreLessonRequest;
use App\Http\Requests\Api\V1\Admin\UpdateLessonRequest;
use App\Http\Resources\V1\LessonCollection;
use App\Http\Resources\V1\LessonResource;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class LessonController extends Controller
{
    public function index(Request $request): LessonCollection
    {
        $lessons = Lesson::with('media')->get();

        return new LessonCollection($lessons);
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function store(StoreLessonRequest $request)
    {
        $lesson = Lesson::create($request->validated());

        $lesson->addMediaFromRequest('video')->toMediaCollection('video');

        return new LessonResource($lesson);
    }

    public function show(Lesson $lesson)
    {
        return new LessonResource($lesson);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        $lesson->update($request->validated());

        if ($request->hasFile('video')) {
            $lesson->clearMediaCollection('video');

            $lesson->addMediaFromRequest('video')->toMediaCollection('video');
        }

        return new LessonResource($lesson);
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return response()->ok();
    }
}
