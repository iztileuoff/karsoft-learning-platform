<?php

namespace App\Http\Controllers\Api\V1\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Front\PresentationCollection;
use App\Http\Resources\V1\Front\PresentationResource;
use App\Models\Presentation;
use Illuminate\Http\Request;

class PresentationController extends Controller
{
    public function index(Request $request): PresentationCollection
    {
        $presentations = Presentation::with('degree', 'media')->paginate($request->input('per_page', 10));

        return new PresentationCollection($presentations);
    }

    public function show(Presentation $presentation)
    {
        return new PresentationResource($presentation->load('degree', 'media'));
    }
}
