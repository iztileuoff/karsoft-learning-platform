<?php

namespace App\Http\Middleware\Api\V1;

use Closure;
use Illuminate\Http\Request;

class AlwaysAcceptJsonMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $request->header('Accept', 'application/json');
        $request->header('Content-Type', 'application/json');

        return $next($request);
    }
}
