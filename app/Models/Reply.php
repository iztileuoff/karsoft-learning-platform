<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reply extends Model
{
    protected $fillable = [
        'review_id',
        'text',
        'creator_id',
    ];

    protected function casts(): array
    {
        return [
            'review_id' => 'int',
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

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }
}
