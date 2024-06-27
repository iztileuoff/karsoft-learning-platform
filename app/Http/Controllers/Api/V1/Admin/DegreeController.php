<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Admin\DegreeCollection;
use App\Models\Degree;
use Illuminate\Http\Request;

class DegreeController extends Controller
{
    public function index(Request $request): DegreeCollection
    {
        $degrees = Degree::all();

        return new DegreeCollection($degrees);
    }
}
