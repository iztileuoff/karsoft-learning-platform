<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Review extends Model
{
    protected $fillable = [
        'text',
        'creator_id',
    ];

    protected function casts(): array
    {
        return [
            'text' => 'string',
            'creator_id' => 'int',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function reply(): HasOne
    {
        return $this->hasOne(Reply::class);
    }
}
