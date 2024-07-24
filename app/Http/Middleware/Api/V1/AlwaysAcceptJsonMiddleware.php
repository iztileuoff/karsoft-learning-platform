<?php

namespace App\Http\Middleware\Api\V1;

use Closure;
use Illuminate\Http\Request;

class AlwaysAcceptJsonMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');
        $request->headers->set('Content-Type', 'application/json');

        return $next($request);
    }
}
