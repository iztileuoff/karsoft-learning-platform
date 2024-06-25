<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Option extends Model
{
    use HasUlids;

    protected $fillable = [
        'question_id',
        'text',
        'correct',
    ];

    protected function casts(): array
    {
        return [
            'question_id' => 'int',
            'text' => 'string',
            'correct' => 'boolean',
        ];
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
