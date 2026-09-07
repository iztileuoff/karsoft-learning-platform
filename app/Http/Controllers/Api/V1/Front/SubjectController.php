<?php

namespace App\Http\Controllers\Api\V1\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Http\Resources\V1\Front\SubjectCollection;

class SubjectController extends Controller
{
    
    public function __invoke(Request $request)
    {
        $subjects = Subject::get();

        return new SubjectCollection($subjects);
    }
}
