<?php

namespace App\Http\Controllers\Api\V1\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Front\SchoolRequest;
use App\Http\Resources\V1\Front\SchoolCollection;
use App\Models\School;
use Illuminate\Support\Facades\Cache;

class SchoolController extends Controller
{
    public function __invoke(SchoolRequest $request): SchoolCollection
    {
        $locale = app()->getLocale();

        if ($request->district_id <= 17) {
            $schools = Cache::remember(
                "schools_{$request->district_id}_{$locale}",
                now()->addHour(),
                function () use ($request) {
                    return School::where('district_id', $request->district_id)->get();
                }
            );
        } else {
            $schools = Cache::remember(
                "schools_{$locale}",
                now()->addHour(),
                function () use ($request) {
                    return School::where('district_id', null)->get();
                }
            );
        }

        return new SchoolCollection($schools);
    }
}
