<?php

namespace App\Providers;

use App\Events\AuthorChanged;
use App\Listeners\InvalidateAuthorCache;
use App\Models\Test;
use App\Policies\TestPolicy;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Response::macro('success', function ($data, $message = null) {
            return response()->json([
                'message' => $message != null ? $message : __('http-statuses.200'),
                'data' => $data
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
    }
}
