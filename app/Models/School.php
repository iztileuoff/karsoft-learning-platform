<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class School extends Model
{
    use HasTranslations;

    protected $fillable = [
        'district_id',
        'name',
    ];

    public array $translatable = [
        'name'
    ];

    protected function casts(): array
    {
        return [
            'district_id' => 'int',
            'name' => 'string',
        ];
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
