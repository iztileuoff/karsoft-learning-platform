<?php

namespace Database\Seeders\V1;

use App\Enums\DegreesEnum;
use App\Enums\LanguagesEnum;
use App\Models\Lesson;
use App\Models\Textbook;
use Illuminate\Database\Seeder;

use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

use function Symfony\Component\Translation\t;

class LessonSeeder extends Seeder
{
    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function run(): void
    {
        $lesson = Lesson::create([
            'name' => "1-sabaq",
        ]);

        $lesson->copyMedia(storage_path('app/videos/1-sabaq.mp4'))->toMediaCollection('video');

        $lesson = Lesson::create([
            'name' => "2-sabaq",
        ]);

        $lesson->copyMedia(storage_path('app/videos/2-sabaq scratch.mp4'))->toMediaCollection('video');

        $lesson = Lesson::create([
            'name' => "3-sabaq",
        ]);

        $lesson->copyMedia(storage_path('app/videos/5-klass Tema Joybar jumisi.mp4'))->toMediaCollection('video');

        $lesson = Lesson::create([
            'name' => "4-sabaq",
        ]);

        $lesson->copyMedia(storage_path('app/videos/Debawlaw procesi.mp4'))->toMediaCollection('video');
    }
}
