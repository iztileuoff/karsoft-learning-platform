<?php

namespace App\Models;

use App\Enums\LanguagesEnum;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Textbook extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'degree_id',
        'language',
        'subject_id',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'description' => 'string',
            'degree_id' => 'int',
            'language' => LanguagesEnum::class,
            'subject_id' => 'int',
        ];
    }

    public function degree(): BelongsTo
    {
        return $this->belongsTo(Degree::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}
