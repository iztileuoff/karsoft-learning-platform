<?php

namespace App\Models;

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
    ];

    protected function casts(): array
    {
        return [
            'quiz_id' => 'string',
            'text' => 'string',
        ];
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    public function correctOption(): HasOne
    {
        return $this->hasOne(Option::class)->where('correct', true);
    }

    public function randomOptions(): HasMany
    {
        return $this->hasMany(Option::class)->inRandomOrder();
    }
}
