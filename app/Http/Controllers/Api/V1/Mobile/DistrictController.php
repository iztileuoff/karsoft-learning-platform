<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Mobile\DistrictCollection;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DistrictController extends Controller
{
    public function __invoke(Request $request): DistrictCollection
    {
        $districts = Cache::remember('districts_' . $request->getLocale(), now()->addHour(), function () {
            return District::get();
        });

        return new DistrictCollection($districts);
    }
}
