<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Mobile\SchoolRequest;
use App\Http\Resources\V1\Mobile\SchoolCollection;
use App\Models\School;
use Illuminate\Support\Facades\Cache;

class SchoolController extends Controller
{
    public function __invoke(SchoolRequest $request): SchoolCollection
    {
        $schools = Cache::remember(
            "schools_{$request->district_id}_{$request->getLocale()}",
            now()->addHour(),
            function () use ($request) {
                return School::where('district_id', $request->district_id)->get();
            }
        );

        return new SchoolCollection($schools);
    }
}
