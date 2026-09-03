<?php

namespace App\Http\Resources\V1\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\AiConversation */
class AiConversationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'title'           => $this->title,
            'source'          => $this->source,
            'last_message_at' => $this->last_message_at?->format('Y-m-d H:i:s'),
            'messages'        => AiMessageResource::collection($this->whenLoaded('messages')),
            'created_at'      => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
