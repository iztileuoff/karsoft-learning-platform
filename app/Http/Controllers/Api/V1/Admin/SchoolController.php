<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\SchoolRequest;
use App\Http\Resources\V1\Admin\SchoolCollection;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index(SchoolRequest $request): SchoolCollection
    {
        $schools = School::where('district_id', $request->district_id)->get();

        return new SchoolCollection($schools);
    }
}
