<?php

namespace App\Http\Controllers\Api\V1\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Front\RegionCollection;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RegionController extends Controller
{
    public function __invoke(Request $request): RegionCollection
    {
        $regions = Cache::remember('regions_' . app()->getLocale(), now()->addHour(), function () {
            return Region::get();
        });

        return new RegionCollection($regions);
    }
}
