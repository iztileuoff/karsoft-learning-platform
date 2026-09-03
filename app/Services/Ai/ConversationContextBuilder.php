<?php

namespace App\Services\Ai;

use App\Enums\AiMessageStatus;
use App\Models\AiConversation;
use App\Models\AiMessage;
use Illuminate\Support\Facades\Storage;

final class ConversationContextBuilder
{
    public function build(AiConversation $conversation): array
    {
        $limit = config('gemini.context_messages_limit', 40);

        return $conversation->messages()
            ->with('attachments')
            ->where('status', AiMessageStatus::Completed)
            ->whereNotNull('content')
            ->latest('id')
            ->limit($limit)
            ->get()
            ->sortBy('id')
            ->values()
            ->map(fn ($msg) => [
                'role'  => $msg->role->value,
                'parts' => $this->buildParts($msg),
            ])
            ->toArray();
    }

    private function buildParts(AiMessage $msg): array
    {
        $parts = [['text' => $msg->content]];

        foreach ($msg->attachments as $attachment) {
            if (! str_starts_with($attachment->mime_type, 'image/')) {
                continue;
            }

            $filePath = Storage::disk('public')->path($attachment->path);

            if (! file_exists($filePath)) {
                continue;
            }

            $parts[] = [
                'inlineData' => [
                    'mimeType' => $attachment->mime_type,
                    'data'     => base64_encode(file_get_contents($filePath)),
                ],
            ];
        }

        return $parts;
    }
}
