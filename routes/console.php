<?php

use App\Models\AiConversation;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// 1 oydan eski AI suhbatlarini o'chirish (kaskad bo'yicha ai_messages ham o'chadi)
Schedule::call(function () {
    $months = config('gemini.history_months', 1);
    AiConversation::where('last_message_at', '<', now()->subMonths($months))
        ->orWhere(function ($q) use ($months) {
            $q->whereNull('last_message_at')
              ->where('created_at', '<', now()->subMonths($months));
        })
        ->delete();
})->daily()->name('ai:prune-history');
