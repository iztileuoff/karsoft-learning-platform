<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
}
