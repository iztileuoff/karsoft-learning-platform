<?php

namespace App\Imports;

use App\Enums\DegreesEnum;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Support\Collection;

class QuestionsImport
{
    public function import(Quiz $quiz, Collection $collection): void
    {
        foreach ($collection as $row) {
            if ($row['correct'] == 1) {
                $question = $quiz->questions()->create([
                    'text' => $row['question_text'],

                ]);

                $question->options()->create([
                    'text' => $row['option1'],
                    'correct' => true,
                ]);

                $question->options()->create([
                    'text' => $row['option2'],
                    'correct' => false,
                ]);

                $question->options()->create([
                    'text' => $row['option3'],
                    'correct' => false,
                ]);

                $question->options()->create([
                    'text' => $row['option4'],
                    'correct' => false,
                ]);

                if (in_array($quiz->degree_id, [DegreesEnum::degree5, DegreesEnum::degree6])) {
                    $question->options()->create([
                        'text' => $row['option5'],
                        'correct' => false,
                    ]);
                }
            }
        }
    }
}
