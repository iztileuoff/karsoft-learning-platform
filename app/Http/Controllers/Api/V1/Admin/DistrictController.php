<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\DistrictCollection;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index(Request $request): DistrictCollection
    {
        $districts = District::get();

        return new DistrictCollection($districts);
    }
}
