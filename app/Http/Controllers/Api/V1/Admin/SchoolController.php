<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Admin\SchoolCollection;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index(Request $request): SchoolCollection
    {
        $schools = School::get();

        return new SchoolCollection($schools);
    }
}
