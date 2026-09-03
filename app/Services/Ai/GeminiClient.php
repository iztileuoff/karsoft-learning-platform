<?php

namespace App\Services\Ai;

use App\Contracts\Ai\ChatClientInterface;
use App\DTO\Ai\GeminiResponseData;
use App\Exceptions\Ai\GeminiException;
use Illuminate\Support\Facades\Http;

final class GeminiClient implements ChatClientInterface
{
    private const RETRYABLE_PHRASES = ['high demand', 'temporarily unavailable', 'overloaded'];

    public function generate(array $messages, string $systemPrompt): GeminiResponseData
    {
        $model    = config('gemini.model');
        $endpoint = rtrim(config('gemini.endpoint'), '/') . "/{$model}:generateContent";
        $apiKey   = config('gemini.api_key');

        $payload = [
            'system_instruction' => [
                'parts' => [['text' => $systemPrompt]],
            ],
            'contents'         => $messages,
            'generationConfig' => [
                'maxOutputTokens' => 8192,
            ],
        ];

        $maxAttempts = 3;
        $start       = microtime(true);
        $response    = null;

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            $response = Http::timeout(config('gemini.timeout', 60))
                ->post("{$endpoint}?key={$apiKey}", $payload);

            if ($response->successful()) {
                break;
            }

            $errorMessage = $response->json('error.message') ?? '';
            $isRetryable  = $response->status() >= 500
                || in_array($response->status(), [429])
                || $this->isRetryableMessage($errorMessage);

            if (! $isRetryable || $attempt === $maxAttempts) {
                $display = $errorMessage ?: "HTTP {$response->status()}";
                throw new GeminiException("Gemini API xatosi: {$display}");
            }

            // exponential backoff: 2s, 4s
            usleep($attempt * 2_000_000);
        }

        $latencyMs = (int) ((microtime(true) - $start) * 1000);

        $data = $response->json();

        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

        if ($text === '') {
            throw new GeminiException('Gemini bo\'sh javob qaytardi.');
        }

        return new GeminiResponseData(
            text:             $text,
            model:            $data['modelVersion'] ?? $model,
            promptTokens:     $data['usageMetadata']['promptTokenCount'] ?? 0,
            completionTokens: $data['usageMetadata']['candidatesTokenCount'] ?? 0,
            totalTokens:      $data['usageMetadata']['totalTokenCount'] ?? 0,
            finishReason:     $data['candidates'][0]['finishReason'] ?? 'UNKNOWN',
            latencyMs:        $latencyMs,
        );
    }

    private function isRetryableMessage(string $message): bool
    {
        $lower = strtolower($message);
        foreach (self::RETRYABLE_PHRASES as $phrase) {
            if (str_contains($lower, $phrase)) {
                return true;
            }
        }
        return false;
    }
}
