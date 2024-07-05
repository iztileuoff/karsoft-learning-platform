<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Test extends Model
{
    protected $fillable = [
        'quiz_id',
        'user_id',
        'started_at',
        'finished_at',
        'time_spent',
        'questions_count',
        'correct_answers_count',
        'percent',
        'data_questions',
    ];

    protected function casts(): array
    {
        return [
            'quiz_id' => 'string',
            'user_id' => 'int',
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
            'time_spent' => 'integer',
            'percent' => 'decimal',
            'questions_count' => 'integer',
            'correct_answers_count' => 'integer',
            'data_questions' => 'array',
        ];
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getOnlyNumberAndTextQuestionsOptions(): ?\Illuminate\Support\Collection
    {
        if ($this->data_questions != null) {
            return collect($this->data_questions)->map(fn($question) => [
                'id' => $question['id'],
                'quiz_id' => $question['quiz_id'],
                'text' => $question['text'],
                'image_url' => $question['image_url'],
                'options' => collect($question['options'])->map(fn($option) => [
                    'number' => $option['number'],
                    'text' => $option['text'],
                    'image_url' => $option['image_url'],
                ])
            ]);
        }

        return null;
    }
}
