<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\RegionCollection;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index(Request $request): RegionCollection
    {
        $regions = Region::get();

        return new RegionCollection($regions);
    }
}
