<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Mobile\IndexPresentationRequest;
use App\Http\Resources\V1\Mobile\PresentationCollection;
use App\Http\Resources\V1\Mobile\PresentationResource;
use App\Models\Presentation;

class PresentationController extends Controller
{
    public function index(IndexPresentationRequest $request): PresentationCollection
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
