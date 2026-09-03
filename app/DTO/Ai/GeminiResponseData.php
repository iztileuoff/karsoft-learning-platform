<?php

namespace App\DTO\Ai;

final readonly class GeminiResponseData
{
    public function __construct(
        public string $text,
        public string $model,
        public int    $promptTokens,
        public int    $completionTokens,
        public int    $totalTokens,
        public string $finishReason,
        public int    $latencyMs,
    ) {}
}
