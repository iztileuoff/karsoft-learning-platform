<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Mobile\SchoolRequest;
use App\Http\Resources\V1\Mobile\SchoolCollection;
use App\Models\School;

class SchoolController extends Controller
{
    public function __invoke(SchoolRequest $request): SchoolCollection
    {
        $schools = School::where('district_id', $request->district_id)->get();

        return new SchoolCollection($schools);
    }
}
