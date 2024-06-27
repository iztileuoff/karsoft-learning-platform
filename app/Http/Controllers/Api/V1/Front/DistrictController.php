<?php

namespace App\Http\Controllers\Api\V1\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Admin\DistrictCollection;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function __invoke(Request $request): DistrictCollection
    {
        $districts = District::get();

        return new DistrictCollection($districts);
    }
}
