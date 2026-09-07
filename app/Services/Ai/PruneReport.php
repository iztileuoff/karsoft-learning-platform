<?php

namespace App\Services\Ai;

final class PruneReport
{
    public function __construct(
        public int $conversations = 0,
        public int $attachments = 0,
        public int $files = 0,
    ) {}
}