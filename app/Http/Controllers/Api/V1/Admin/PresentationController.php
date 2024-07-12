<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\StorePresentationRequest;
use App\Http\Requests\Api\V1\Admin\UpdatePresentationRequest;
use App\Http\Resources\V1\Admin\PresentationCollection;
use App\Http\Resources\V1\Admin\PresentationResource;
use App\Models\Presentation;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class PresentationController extends Controller
{
    public function index(Request $request): PresentationCollection
    {
        $presentations = Presentation::with('degree', 'media')->paginate($request->input('per_page', 10));

        return new PresentationCollection($presentations);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(StorePresentationRequest $request)
    {
        $presentation = Presentation::create($request->validated());

        $presentation->addMediaFromRequest('file')->toMediaCollection('file');

        $presentation->addMediaFromRequest('image')->toMediaCollection('image');

        return new PresentationResource($presentation);
    }

    public function show(Presentation $presentation)
    {
        return new PresentationResource($presentation->load('degree', 'media'));
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function update(UpdatePresentationRequest $request, Presentation $presentation)
    {
        $presentation->update($request->validated());

        if ($request->hasFile('file')) {
            $presentation->clearMediaCollection('file');

            $presentation->addMediaFromRequest('file')->toMediaCollection('file');
        }

        if ($request->hasFile('image')) {
            $presentation->clearMediaCollection('image');

            $presentation->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return new PresentationResource($presentation);
    }

    public function destroy(Presentation $presentation)
    {
        $presentation->delete();

        return response()->ok();
    }
}
