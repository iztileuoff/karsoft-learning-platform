<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Info extends Model
{
    use HasTranslations;

    protected $fillable = [
        'text',
        'mobile'
    ];

    public array $translatable = [
        'text'
    ];

    protected function casts(): array
    {
        return [
            'text' => 'string',
            'mobile' => 'boolean',
        ];
    }
}
