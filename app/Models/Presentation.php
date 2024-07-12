<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Presentation extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'degree_id',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'degree_id' => 'int',
        ];
    }

    public function degree(): BelongsTo
    {
        return $this->belongsTo(Degree::class);
    }
}
