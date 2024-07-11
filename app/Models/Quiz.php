<?php

namespace App\Models;

use App\Enums\DegreesEnum;
use App\Enums\LanguagesEnum;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Quiz extends Model
{
    use HasUlids;

    protected $fillable = [
        'name',
        'description',
        'degree_id',
        'language',
        'number_of_questions',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'description' => 'string',
            'degree_id' => DegreesEnum::class,
            'language' => LanguagesEnum::class,
            'number_of_questions' => 'integer',
        ];
    }

    public function degree(): BelongsTo
    {
        return $this->belongsTo(Degree::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function randomQuestions(): HasMany
    {
        return $this->hasMany(Question::class)->inRandomOrder();
    }

    public function test(): HasOne
    {
        return $this->hasOne(Test::class)
            ->where('user_id', auth()->id())
            ->select(
                [
                    'id',
                    'quiz_id',
                    'user_id',
                    'started_at',
                    'finished_at',
                    'time_spent',
                    'questions_count',
                    'correct_answers_count',
                    'percent'
                ]
            );
    }
}
