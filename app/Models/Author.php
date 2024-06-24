<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Author extends Model
{
    use HasTranslations;

    protected $fillable = [
        'first_name',
        'last_name',
        'description',
    ];

    public array $translatable = [
        'description',
    ];

    protected function casts(): array
    {
        return [
            'first_name' => 'string',
            'last_name' => 'string',
            'description' => 'string',
        ];
    }
}
