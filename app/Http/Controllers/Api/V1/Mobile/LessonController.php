<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Mobile\LessonCollection;
use App\Http\Resources\V1\Mobile\LessonResource;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(Request $request): LessonCollection
    {
        $lessons = Lesson::with('media')->get();

        return new LessonCollection($lessons);
    }

    public function show(Lesson $lesson)
    {
        return new LessonResource($lesson);
    }
}
