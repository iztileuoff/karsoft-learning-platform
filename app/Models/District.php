<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class District extends Model
{
    use HasTranslations;

    protected $fillable = [
        'region_id',
        'name',
    ];

    public array $translatable = [
        'name',
    ];

    protected function casts(): array
    {
        return [
            'region_id' => 'int',
            'name' => 'string',
        ];
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
