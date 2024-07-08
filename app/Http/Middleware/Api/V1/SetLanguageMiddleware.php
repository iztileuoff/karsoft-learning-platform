<?php

namespace App\Http\Middleware\Api\V1;

use App\Enums\LanguagesEnum;
use Closure;
use Illuminate\Http\Request;

class SetLanguageMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $language = $request->header('Accept-Language', 'kaa');

        if (!in_array($language, [LanguagesEnum::kaa->value, LanguagesEnum::uz->value])) {
            app()->setLocale('kaa');
        } else {
            app()->setLocale($language);
        }

        return $next($request);
    }
}
