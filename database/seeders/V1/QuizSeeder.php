<?php

namespace Database\Seeders\V1;

use App\Enums\DegreesEnum;
use App\Enums\LanguagesEnum;
use App\Imports\QuestionsImport;
use App\Models\District;
use App\Models\Post;
use App\Models\Quiz;
use App\Models\Region;
use App\Models\School;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Common\Exception\UnsupportedTypeException;
use OpenSpout\Reader\Exception\ReaderNotOpenedException;
use Rap2hpoutre\FastExcel\FastExcel;

class QuizSeeder extends Seeder
{
    /**
     * @throws IOException
     * @throws UnsupportedTypeException
     * @throws ReaderNotOpenedException
     */
    public function run(): void
    {
        $quiz = Quiz::create([
            'name' => '5-klass. Test',
            'description' => 'description',
            'degree_id' => DegreesEnum::degree5,
            'language' => LanguagesEnum::kaa,
            'number_of_questions' => 30,
        ]);

        $collection = (new FastExcel())->import(storage_path('app/quizzes/5-kaa.xlsx'));
        (new QuestionsImport())->import($quiz, $collection);

        $quiz = Quiz::create([
            'name' => '5-sinf. Test',
            'description' => 'description',
            'degree_id' => DegreesEnum::degree5,
            'language' => LanguagesEnum::uz,
            'number_of_questions' => 30,
        ]);

        $collection = (new FastExcel())->import(storage_path('app/quizzes/5-uz.xlsx'));
        (new QuestionsImport())->import($quiz, $collection);

        $quiz = Quiz::create([
            'name' => '6-klass. Test',
            'description' => 'description',
            'degree_id' => DegreesEnum::degree6,
            'language' => LanguagesEnum::kaa,
            'number_of_questions' => 30,
        ]);

        $collection = (new FastExcel())->import(storage_path('app/quizzes/6-kaa.xlsx'));
        (new QuestionsImport())->import($quiz, $collection);

        $quiz = Quiz::create([
            'name' => '6-sinf. Test',
            'description' => 'description',
            'degree_id' => DegreesEnum::degree6,
            'language' => LanguagesEnum::uz,
            'number_of_questions' => 30,
        ]);

        $collection = (new FastExcel())->import(storage_path('app/quizzes/6-uz.xlsx'));
        (new QuestionsImport())->import($quiz, $collection);

        $quiz = Quiz::create([
            'name' => '7-klass. Test',
            'description' => 'description',
            'degree_id' => DegreesEnum::degree7,
            'language' => LanguagesEnum::kaa,
            'number_of_questions' => 30,
        ]);

        $collection = (new FastExcel())->import(storage_path('app/quizzes/7-kaa.xlsx'));
        (new QuestionsImport())->import($quiz, $collection);

        $quiz = Quiz::create([
            'name' => '7-sinf. Test',
            'description' => 'description',
            'degree_id' => DegreesEnum::degree7,
            'language' => LanguagesEnum::uz,
            'number_of_questions' => 30,
        ]);

        $collection = (new FastExcel())->import(storage_path('app/quizzes/7-uz.xlsx'));
        (new QuestionsImport())->import($quiz, $collection);

        $quiz = Quiz::create([
            'name' => '8-klass. Test',
            'description' => 'description',
            'degree_id' => DegreesEnum::degree8,
            'language' => LanguagesEnum::kaa,
            'number_of_questions' => 30,
        ]);

        $collection = (new FastExcel())->import(storage_path('app/quizzes/8-kaa.xlsx'));
        (new QuestionsImport())->import($quiz, $collection);

        $quiz = Quiz::create([
            'name' => '8-sinf. Test',
            'description' => 'description',
            'degree_id' => DegreesEnum::degree8,
            'language' => LanguagesEnum::uz,
            'number_of_questions' => 30,
        ]);

        $collection = (new FastExcel())->import(storage_path('app/quizzes/8-uz.xlsx'));
        (new QuestionsImport())->import($quiz, $collection);

        $quiz = Quiz::create([
            'name' => '9-klass. Test',
            'description' => 'description',
            'degree_id' => DegreesEnum::degree9,
            'language' => LanguagesEnum::kaa,
            'number_of_questions' => 30,
        ]);

        $collection = (new FastExcel())->import(storage_path('app/quizzes/9-kaa.xlsx'));
        (new QuestionsImport())->import($quiz, $collection);

        $quiz = Quiz::create([
            'name' => '9-sinf. Test',
            'description' => 'description',
            'degree_id' => DegreesEnum::degree9,
            'language' => LanguagesEnum::uz,
            'number_of_questions' => 30,
        ]);

        $collection = (new FastExcel())->import(storage_path('app/quizzes/9-uz.xlsx'));
        (new QuestionsImport())->import($quiz, $collection);

        $quiz = Quiz::create([
            'name' => '10-klass. Test',
            'description' => 'description',
            'degree_id' => DegreesEnum::degree10,
            'language' => LanguagesEnum::kaa,
            'number_of_questions' => 30,
        ]);

        $collection = (new FastExcel())->import(storage_path('app/quizzes/10-kaa.xlsx'));
        (new QuestionsImport())->import($quiz, $collection);

        $quiz = Quiz::create([
            'name' => '10-sinf. Test',
            'description' => 'description',
            'degree_id' => DegreesEnum::degree10,
            'language' => LanguagesEnum::uz,
            'number_of_questions' => 30,
        ]);

        $collection = (new FastExcel())->import(storage_path('app/quizzes/10-uz.xlsx'));
        (new QuestionsImport())->import($quiz, $collection);

        $quiz = Quiz::create([
            'name' => '11-klass. Test',
            'description' => 'description',
            'degree_id' => DegreesEnum::degree11,
            'language' => LanguagesEnum::kaa,
            'number_of_questions' => 30,
        ]);

        $collection = (new FastExcel())->import(storage_path('app/quizzes/11-kaa.xlsx'));
        (new QuestionsImport())->import($quiz, $collection);

        $quiz = Quiz::create([
            'name' => '11-sinf. Test',
            'description' => 'description',
            'degree_id' => DegreesEnum::degree11,
            'language' => LanguagesEnum::uz,
            'number_of_questions' => 30,
        ]);

        $collection = (new FastExcel())->import(storage_path('app/quizzes/11-uz.xlsx'));
        (new QuestionsImport())->import($quiz, $collection);
    }
}
