<?php

namespace App\Contracts\Ai;

use App\DTO\Ai\GeminiResponseData;

interface ChatClientInterface
{
    public function generate(array $messages, string $systemPrompt): GeminiResponseData;
}
