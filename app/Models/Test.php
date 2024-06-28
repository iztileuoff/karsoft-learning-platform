<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'data_questions',
    ];

    protected function casts()
    {
        return [
            'started_at' => 'timestamp',
            'finished_at' => 'timestamp',
            'data_questions' => 'array',
        ];
    }
}
