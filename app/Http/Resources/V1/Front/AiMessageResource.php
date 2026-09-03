<?php

namespace App\Http\Resources\V1\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\AiMessage */
class AiMessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'conversation_id'   => $this->ai_conversation_id,
            'role'              => $this->role->value,
            'content'           => $this->content,
            'status'            => $this->status->value,
            'client_message_id' => $this->client_message_id,
            'created_at'        => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
