<?php

namespace Database\Seeders\V1;

use App\Models\Lesson;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

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

        $lesson = Lesson::create([
            'name' => "5-sabaq",
        ]);

        $lesson->copyMedia(storage_path('app/videos/6-klass scratch.mp4'))->toMediaCollection('video');

        $lesson = Lesson::create([
            'name' => "6-sabaq",
        ]);

        $lesson->copyMedia(storage_path('app/videos/6-klass Tekst qosiw ozgertiw koshiriw.mp4'))->toMediaCollection(
            'video'
        );

        $lesson = Lesson::create([
            'name' => "7-sabaq",
        ]);

        $lesson->copyMedia(storage_path('app/videos/7-klass internetten paydalaniw word.mp4'))->toMediaCollection(
            'video'
        );

        $lesson = Lesson::create([
            'name' => "8-sabaq",
        ]);

        $lesson->copyMedia(storage_path('app/videos/7-klass Excel.mp4'))->toMediaCollection('video');
    }
}
