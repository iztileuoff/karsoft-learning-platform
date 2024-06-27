<?php

namespace App\Http\Controllers\Api\V1\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Front\SchoolRequest;
use App\Http\Resources\V1\SchoolCollection;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function __invoke(SchoolRequest $request): SchoolCollection
    {
        $schools = School::where('district_id', $request->district_id)->get();

        return new SchoolCollection($schools);
    }
}
