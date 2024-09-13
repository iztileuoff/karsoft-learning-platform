<?php

namespace App\Http\Controllers\Api\V1\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Front\DistrictRequest;
use App\Http\Resources\V1\Front\DistrictCollection;
use App\Models\District;

class DistrictController extends Controller
{
    public function __invoke(DistrictRequest $request): DistrictCollection
    {
        $districts = District::when($request->region_id, function ($query) use ($request) {
            return $query->where('region_id', $request->region_id);
        })
            ->get();

        return new DistrictCollection($districts);
    }
}
