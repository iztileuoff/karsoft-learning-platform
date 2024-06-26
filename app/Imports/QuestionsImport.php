<?php

namespace App\Imports;

use App\Enums\DegreesEnum;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class QuestionsImport
{
    public function import(Quiz $quiz, Collection $collection): void
    {
        foreach ($collection as $row) {
            if ($row['correct'] == 1) {
                $options = [];

                $options[] = [
                    'number' => Str::ulid()->toString(),
                    'text' => $row['option1'],
                    'correct' => true,
                ];

                $options[] = [
                    'number' => Str::ulid()->toString(),
                    'text' => $row['option2'],
                    'correct' => false,
                ];

                $options[] = [
                    'number' => Str::ulid()->toString(),
                    'text' => $row['option3'],
                    'correct' => false,
                ];

                $options[] = [
                    'number' => Str::ulid()->toString(),
                    'text' => $row['option4'],
                    'correct' => false,
                ];

                if (in_array($quiz->degree_id, [DegreesEnum::degree5, DegreesEnum::degree6])) {
                    $options[] = [
                        'number' => Str::ulid()->toString(),
                        'text' => $row['option5'],
                        'correct' => false,
                    ];
                }

                $question = $quiz->questions()->create([
                    'text' => $row['question_text'],
                    'options' => $options,
                ]);
            }
        }
    }
}
