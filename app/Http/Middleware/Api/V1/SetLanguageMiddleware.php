<?php

namespace App\Http\Middleware\Api\V1;

use Closure;
use Illuminate\Http\Request;

class SetLanguageMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        app()->setLocale($request->header('Accept-Language', 'kaa'));

        return $next($request);
    }
}
