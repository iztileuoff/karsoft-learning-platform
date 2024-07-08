<?php

namespace App\Http\Controllers\Api\V1\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Front\LessonCollection;
use App\Http\Resources\V1\Front\LessonResource;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LessonController extends Controller
{
    public function index(Request $request): LessonCollection
    {
        $lessons = Cache::remember('lessons', now()->addHour(), function () {
            return Lesson::with('media')->get();
        });

        return new LessonCollection($lessons);
    }

    public function show(Lesson $lesson)
    {
        return new LessonResource($lesson);
    }
}
