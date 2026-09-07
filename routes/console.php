<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Delete AI conversations, messages, and uploaded files older than configured months
Schedule::command('ai:prune-history')
    ->dailyAt('03:10')
    ->name('ai:prune-history')
    ->withoutOverlapping(30);