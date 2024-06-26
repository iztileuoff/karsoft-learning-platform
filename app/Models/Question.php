<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Question extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'quiz_id',
        'text',
        'options',
    ];

    protected function casts(): array
    {
        return [
            'quiz_id' => 'string',
            'text' => 'string',
            'options' => 'array',
        ];
    }

    public function scopeName(Builder $query, $search): void
    {
        $query->where('text', 'like', "%$search%");
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
