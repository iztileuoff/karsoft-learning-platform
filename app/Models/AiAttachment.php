<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiAttachment extends Model
{
    protected $fillable = [
        'user_id',
        'ai_message_id',
        'path',
        'mime_type',
        'original_name',
        'size',
    ];

    protected function casts(): array
    {
        return [
            'user_id'       => 'int',
            'ai_message_id' => 'int',
            'size'          => 'int',
            'created_at'    => 'datetime',
            'updated_at'    => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function message(): BelongsTo
    {
        return $this->belongsTo(AiMessage::class, 'ai_message_id');
    }
}
