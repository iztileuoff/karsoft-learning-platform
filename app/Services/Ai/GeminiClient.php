<?php

namespace App\Services\Ai;

use App\Contracts\Ai\ChatClientInterface;
use App\DTO\Ai\GeminiResponseData;
use App\Exceptions\Ai\GeminiException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

final class GeminiClient implements ChatClientInterface
{
    private const RETRYABLE_PHRASES = ['high demand', 'temporarily unavailable', 'overloaded'];

    private const MAX_ATTEMPTS = 2;

    public function generate(array $messages, string $systemPrompt): GeminiResponseData
    {
        $model = config('gemini.model');
        $endpoint = rtrim(config('gemini.endpoint'), '/')."/{$model}:generateContent";

        $payload = [
            'system_instruction' => [
                'parts' => [['text' => $systemPrompt]],
            ],
            'contents' => $messages,
            'generationConfig' => [
                'maxOutputTokens' => 8192,
            ],
        ];

        $start = microtime(true);
        $response = null;

        try {
            for ($attempt = 1; $attempt <= self::MAX_ATTEMPTS; $attempt++) {
                $response = Http::timeout(config('gemini.timeout', 30))
                    ->connectTimeout(config('gemini.connect_timeout', 10))
                    ->withHeaders(['x-goog-api-key' => config('gemini.api_key')])
                    ->post($endpoint, $payload);

                if ($response->successful()) {
                    break;
                }

                $status = $response->status();
                $errorMessage = $response->json('error.message') ?? '';

                if ($status === 429) {
                    throw GeminiException::quotaExceeded($errorMessage);
                }

                $isRetryable = in_array($status, [503, 504])
                    || $this->isRetryableMessage($errorMessage);

                if (! $isRetryable || $attempt === self::MAX_ATTEMPTS) {
                    throw $isRetryable
                        ? GeminiException::overloaded($errorMessage)
                        : new GeminiException('Gemini API xatosi: '.($errorMessage ?: "HTTP {$status}"));
                }

                sleep(config('gemini.retry_delay', 3));
            }
        } catch (ConnectionException $e) {
            throw GeminiException::timeout($e);
        }

        $latencyMs = (int) ((microtime(true) - $start) * 1000);

        $data = $response->json();
        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

        if ($text === '') {
            throw new GeminiException('Gemini bo\'sh javob qaytardi.');
        }

        return new GeminiResponseData(
            text: $text,
            model: $data['modelVersion'] ?? $model,
            promptTokens: $data['usageMetadata']['promptTokenCount'] ?? 0,
            completionTokens: $data['usageMetadata']['candidatesTokenCount'] ?? 0,
            totalTokens: $data['usageMetadata']['totalTokenCount'] ?? 0,
            finishReason: $data['candidates'][0]['finishReason'] ?? 'UNKNOWN',
            latencyMs: $latencyMs,
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
