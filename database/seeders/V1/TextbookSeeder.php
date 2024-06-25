<?php

namespace Database\Seeders\V1;

use App\Enums\DegreesEnum;
use App\Enums\LanguagesEnum;
use App\Models\Author;
use App\Models\Info;
use App\Models\Post;
use App\Models\Textbook;
use Illuminate\Database\Seeder;

use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

use function Symfony\Component\Translation\t;

class TextbookSeeder extends Seeder
{
    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function run(): void
    {
        $textbook = Textbook::create([
            'name' => "5-klass. Informatika hám informaciyalıq texnologiyaları",
            'description' => "description",
            'degree_id' => DegreesEnum::degree5,
            'language' => LanguagesEnum::kaa,
        ]);

        $textbook->copyMedia(storage_path('app/textbooks/kaa/ICT_STB_G5_QQ_18.04.2024.pdf'))->toMediaCollection('file');

        $textbook = Textbook::create([
            'name' => "5-sinf. Informatika va axborot texnologiyalari",
            'description' => "description",
            'degree_id' => DegreesEnum::degree5,
            'language' => LanguagesEnum::uz,
        ]);

        $textbook->copyMedia(storage_path('app/textbooks/uz/ICT_G05_STB.pdf'))->toMediaCollection('file');

        $textbook = Textbook::create([
            'name' => "6-klass. Informatika hám informaciyalıq texnologiyaları",
            'description' => "description",
            'degree_id' => DegreesEnum::degree6,
            'language' => LanguagesEnum::kaa,
        ]);

        $textbook->copyMedia(storage_path('app/textbooks/kaa/ICT_STB_G6_QQ_17.04.2024.pdf'))->toMediaCollection('file');

        $textbook = Textbook::create([
            'name' => "6-sinf. Informatika va axborot texnologiyalari",
            'description' => "description",
            'degree_id' => DegreesEnum::degree6,
            'language' => LanguagesEnum::uz,
        ]);

        $textbook->copyMedia(storage_path('app/textbooks/uz/ICT_G06_STB.pdf'))->toMediaCollection('file');

        $textbook = Textbook::create([
            'name' => "7-klass. Informatika hám informaciyalıq texnologiyaları",
            'description' => "description",
            'degree_id' => DegreesEnum::degree7,
            'language' => LanguagesEnum::kaa,
        ]);

        $textbook->copyMedia(storage_path('app/textbooks/kaa/ICT_STB_G7_QQ_17.04.2024.pdf'))->toMediaCollection('file');

        $textbook = Textbook::create([
            'name' => "7-sinf. Informatika va axborot texnologiyalari",
            'description' => "description",
            'degree_id' => DegreesEnum::degree7,
            'language' => LanguagesEnum::uz,
        ]);

        $textbook->copyMedia(storage_path('app/textbooks/uz/ICT_G07_STB.pdf'))->toMediaCollection('file');

        $textbook = Textbook::create([
            'name' => "8-klass. Informatika hám informaciyalıq texnologiyaları",
            'description' => "description",
            'degree_id' => DegreesEnum::degree8,
            'language' => LanguagesEnum::kaa,
        ]);

        $textbook->copyMedia(storage_path('app/textbooks/kaa/ICT_STB_G8_QQ_17.04.2024.pdf'))->toMediaCollection('file');

        $textbook = Textbook::create([
            'name' => "8-sinf. Informatika va axborot texnologiyalari",
            'description' => "description",
            'degree_id' => DegreesEnum::degree8,
            'language' => LanguagesEnum::uz,
        ]);

        $textbook->copyMedia(storage_path('app/textbooks/uz/ICT_G08_STB.pdf'))->toMediaCollection('file');

        $textbook = Textbook::create([
            'name' => "9-klass. Informatika hám informaciyalıq texnologiyaları",
            'description' => "description",
            'degree_id' => DegreesEnum::degree9,
            'language' => LanguagesEnum::kaa,
        ]);

        $textbook->copyMedia(storage_path('app/textbooks/kaa/ICT_STB_G9_QQ_18.04.2024.pdf'))->toMediaCollection('file');

        $textbook = Textbook::create([
            'name' => "9-sinf. Informatika va axborot texnologiyalari",
            'description' => "description",
            'degree_id' => DegreesEnum::degree9,
            'language' => LanguagesEnum::uz,
        ]);

        $textbook->copyMedia(storage_path('app/textbooks/uz/ICT_G09_STB.pdf'))->toMediaCollection('file');

        $textbook = Textbook::create([
            'name' => "10-klass. Informatika hám informaciyalıq texnologiyaları",
            'description' => "description",
            'degree_id' => DegreesEnum::degree10,
            'language' => LanguagesEnum::kaa,
        ]);

        $textbook->copyMedia(storage_path('app/textbooks/kaa/ICT_STB_G10-11_QQ_18.04.2024.pdf'))->toMediaCollection('file');

        $textbook = Textbook::create([
            'name' => "10-sinf. Informatika va axborot texnologiyalari",
            'description' => "description",
            'degree_id' => DegreesEnum::degree10,
            'language' => LanguagesEnum::uz,
        ]);

        $textbook->copyMedia(storage_path('app/textbooks/uz/ICT_G10-11_STB.pdf'))->toMediaCollection('file');

        $textbook = Textbook::create([
            'name' => "11-klass. Informatika hám informaciyalıq texnologiyaları",
            'description' => "description",
            'degree_id' => DegreesEnum::degree11,
            'language' => LanguagesEnum::kaa,
        ]);

        $textbook->copyMedia(storage_path('app/textbooks/kaa/ICT_STB_G10-11_QQ_18.04.2024.pdf'))->toMediaCollection('file');

        $textbook = Textbook::create([
            'name' => "11-sinf. Informatika va axborot texnologiyalari",
            'description' => "description",
            'degree_id' => DegreesEnum::degree11,
            'language' => LanguagesEnum::uz,
        ]);

        $textbook->copyMedia(storage_path('app/textbooks/uz/ICT_G10-11_STB.pdf'))->toMediaCollection('file');
    }
}
