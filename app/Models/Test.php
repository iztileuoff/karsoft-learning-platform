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
        'correct_questions_count',
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
            'questions_count' => 'integer',
            'correct_questions_count' => 'integer',
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
}
