<?php

namespace App\Exceptions\Ai;

use RuntimeException;
use Throwable;

final class GeminiException extends RuntimeException
{
    public function __construct(
        string $message = '',
        private readonly int $httpStatus = 502,
        private readonly string $errorCode = 'ai_error',
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, 0, $previous);
    }

    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public static function timeout(?Throwable $previous = null): self
    {
        return new self('AI xizmati vaqt limiti oshdi.', 504, 'ai_timeout', $previous);
    }

    public static function overloaded(string $detail = ''): self
    {
        return new self(
            $detail ?: 'AI xizmati hozir band, keyinroq urinib ko\'ring.',
            503,
            'ai_overloaded',
        );
    }

    public static function quotaExceeded(string $detail = ''): self
    {
        return new self(
            $detail ?: 'AI xizmati kvotasi tugagan.',
            503,
            'ai_quota_exceeded',
        );
    }
}
