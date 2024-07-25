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
        $presentations = Presentation::when($request->degree_id, function ($query) use ($request) {
            $query->where('degree_id', $request->degree_id);
        })
            ->with('degree', 'media')
            ->get();

        return new PresentationCollection($presentations);
    }

    public function show(Presentation $presentation)
    {
        return new PresentationResource($presentation->load('degree', 'media'));
    }
}
