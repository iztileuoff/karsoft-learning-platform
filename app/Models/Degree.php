<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Degree extends Model
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

    public function textbooks(): HasMany
    {
        return $this->hasMany(Textbook::class);
    }
}
