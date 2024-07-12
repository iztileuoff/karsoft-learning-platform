<?php

namespace Database\Seeders\V1;

use App\Enums\DegreesEnum;
use App\Models\Presentation;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class PresentationSeeder extends Seeder
{
    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function run(): void
    {
        $presentation = Presentation::create([
            'name' => "presentation_1",
            'degree_id' => DegreesEnum::degree5,
        ]);

        $presentation->copyMedia(storage_path('app/presentations/5-klass 1.pdf'))->toMediaCollection('file');
        $presentation->copyMedia(
            storage_path('app/presentations/images/image_2024-07-12_12-10-01.png')
        )->toMediaCollection('image');

        $presentation = Presentation::create([
            'name' => "presentation_2",
            'degree_id' => DegreesEnum::degree5,
        ]);

        $presentation->copyMedia(storage_path('app/presentations/5-klass 2.pdf'))->toMediaCollection('file');
        $presentation->copyMedia(
            storage_path('app/presentations/images/image_2024-07-12_12-10-27.png')
        )->toMediaCollection('image');

        $presentation = Presentation::create([
            'name' => "presentation_3",
            'degree_id' => DegreesEnum::degree5,
        ]);

        $presentation->copyMedia(storage_path('app/presentations/5-klass 3.pdf'))->toMediaCollection('file');
        $presentation->copyMedia(
            storage_path('app/presentations/images/image_2024-07-12_12-10-57.png')
        )->toMediaCollection('image');

        $presentation = Presentation::create([
            'name' => "presentation_4",
            'degree_id' => DegreesEnum::degree5,
        ]);

        $presentation->copyMedia(storage_path('app/presentations/5-klass 4.pdf'))->toMediaCollection('file');
        $presentation->copyMedia(
            storage_path('app/presentations/images/image_2024-07-12_12-12-26.png')
        )->toMediaCollection('image');

        $presentation = Presentation::create([
            'name' => "presentation_5",
            'degree_id' => DegreesEnum::degree5,
        ]);

        $presentation->copyMedia(storage_path('app/presentations/5-klass 5.pdf'))->toMediaCollection('file');
        $presentation->copyMedia(
            storage_path('app/presentations/images/image_2024-07-12_12-13-02.png')
        )->toMediaCollection('image');

        $presentation = Presentation::create([
            'name' => "presentation_6",
            'degree_id' => DegreesEnum::degree6,
        ]);

        $presentation->copyMedia(storage_path('app/presentations/6-klass 1.pdf'))->toMediaCollection('file');
        $presentation->copyMedia(
            storage_path('app/presentations/images/image_2024-07-12_12-13-21.png')
        )->toMediaCollection('image');

        $presentation = Presentation::create([
            'name' => "presentation_7",
            'degree_id' => DegreesEnum::degree6,
        ]);

        $presentation->copyMedia(storage_path('app/presentations/6-klass 2.pdf'))->toMediaCollection('file');
        $presentation->copyMedia(
            storage_path('app/presentations/images/image_2024-07-12_12-13-44.png')
        )->toMediaCollection('image');

        $presentation = Presentation::create([
            'name' => "presentation_8",
            'degree_id' => DegreesEnum::degree6,
        ]);

        $presentation->copyMedia(storage_path('app/presentations/6-klass 3.pdf'))->toMediaCollection('file');
        $presentation->copyMedia(
            storage_path('app/presentations/images/image_2024-07-12_12-14-03.png')
        )->toMediaCollection('image');

        $presentation = Presentation::create([
            'name' => "presentation_9",
            'degree_id' => DegreesEnum::degree6,
        ]);

        $presentation->copyMedia(storage_path('app/presentations/6-klass 4.pdf'))->toMediaCollection('file');
        $presentation->copyMedia(
            storage_path('app/presentations/images/image_2024-07-12_12-14-16.png')
        )->toMediaCollection('image');

        $presentation = Presentation::create([
            'name' => "presentation_10",
            'degree_id' => DegreesEnum::degree6,
        ]);

        $presentation->copyMedia(storage_path('app/presentations/6-klass 5.pdf'))->toMediaCollection('file');
        $presentation->copyMedia(
            storage_path('app/presentations/images/image_2024-07-12_12-14-33.png')
        )->toMediaCollection('image');
    }
}
