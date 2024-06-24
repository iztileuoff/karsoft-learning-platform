<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Region extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
    ];

    public array $translatable = [
        'name',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'string',
        ];
    }

    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }
}
