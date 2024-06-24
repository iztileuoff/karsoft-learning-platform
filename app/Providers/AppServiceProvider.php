<?php

namespace App\Providers;

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
        //
    }
}
