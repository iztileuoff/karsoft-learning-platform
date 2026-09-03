<?php

namespace App\Models;

use App\Enums\AiMessageRole;
use App\Enums\AiMessageStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AiMessage extends Model
{
    protected $fillable = [
        'ai_conversation_id',
        'role',
        'content',
        'status',
        'client_message_id',
        'reply_to_id',
        'model',
        'prompt_tokens',
        'completion_tokens',
        'total_tokens',
        'finish_reason',
        'latency_ms',
        'error',
    ];

    protected function casts(): array
    {
        return [
            'role'              => AiMessageRole::class,
            'status'            => AiMessageStatus::class,
            'prompt_tokens'     => 'int',
            'completion_tokens' => 'int',
            'total_tokens'      => 'int',
            'latency_ms'        => 'int',
            'created_at'        => 'datetime',
            'updated_at'        => 'datetime',
        ];
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(AiConversation::class, 'ai_conversation_id');
    }

    public function reply(): HasOne
    {
        return $this->hasOne(AiMessage::class, 'reply_to_id');
    }

    public function replyTo(): BelongsTo
    {
        return $this->belongsTo(AiMessage::class, 'reply_to_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(AiAttachment::class);
    }
}
