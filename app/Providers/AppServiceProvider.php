<?php

namespace App\Providers;

use App\Contracts\Ai\ChatClientInterface;
use App\Events\AuthorChanged;
use App\Events\LessonChanged;
use App\Events\TextbookChanged;
use App\Listeners\InvalidateAuthorCache;
use App\Listeners\InvalidateLessonCache;
use App\Listeners\InvalidateTextbookCache;
use App\Models\Test;
use App\Policies\TestPolicy;
use App\Services\Ai\GeminiClient;
use App\Services\Ai\PruneAiHistory;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && config('telescope.enabled', false)) {
            $this->app->register(TelescopeServiceProvider::class);
        }

        $this->app->bind(ChatClientInterface::class, GeminiClient::class);
        $this->app->bind(PruneAiHistory::class, fn () => new PruneAiHistory(
            Storage::disk(config('gemini.attachment_disk', 'public'))
        ));

        Response::macro('success', function ($data, $message = null) {
            return response()->json([
                'message' => $message != null ? $message : __('http-statuses.200'),
                'data' => $data,
            ]);
        });

        Response::macro('ok', function ($message = null) {
            return response()->json([
                'message' => $message != null ? $message : __('http-statuses.200'),
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Test::class, TestPolicy::class);

        Event::listen(AuthorChanged::class, InvalidateAuthorCache::class);
        Event::listen(TextbookChanged::class, InvalidateTextbookCache::class);
        Event::listen(LessonChanged::class, InvalidateLessonCache::class);

        RateLimiter::for('ai-chat', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->user()?->id ?: $request->ip())
                ->response(fn (Request $req, array $headers) => response()->json([
                    'message' => 'Juda ko\'p so\'rov. Keyinroq urinib ko\'ring.',
                    'code' => 'rate_limit_exceeded',
                ], 429, $headers));
        });
    }
}
