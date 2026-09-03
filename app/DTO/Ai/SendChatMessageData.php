<?php

namespace App\DTO\Ai;

final readonly class SendChatMessageData
{
    public function __construct(
        public string  $message,
        public string  $clientMessageId,
        public string  $source,
        public ?int    $conversationId   = null,
        public array   $attachmentIds    = [],
    ) {}
}
