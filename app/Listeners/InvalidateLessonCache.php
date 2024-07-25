<?php

namespace App\Listeners;

use App\Events\AuthorChanged;
use Illuminate\Support\Facades\Cache;

class InvalidateLessonCache
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AuthorChanged $event): void
    {
        Cache::forget('lessons');
    }
}
