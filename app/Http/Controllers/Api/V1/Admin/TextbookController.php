<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\StoreTextbookRequest;
use App\Http\Requests\Api\V1\Admin\UpdateTextbookRequest;
use App\Http\Resources\V1\Admin\TextbookCollection;
use App\Http\Resources\V1\Admin\TextbookResource;
use App\Models\Textbook;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class TextbookController extends Controller
{
    public function index(Request $request): TextbookCollection
    {
        $textbooks = Textbook::with('media', 'degree')->get();

        return new TextbookCollection($textbooks);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(StoreTextbookRequest $request): TextbookResource
    {
        $textbook = Textbook::create($request->validated());

        $textbook->addMediaFromRequest('file')->toMediaCollection('file');

        $textbook->addMediaFromRequest('image')->toMediaCollection('image');

        return new TextbookResource($textbook);
    }

    public function show(Textbook $textbook): TextbookResource
    {
        return new TextbookResource($textbook->load('media', 'degree'));
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function update(UpdateTextbookRequest $request, Textbook $textbook): TextbookResource
    {
        $textbook->update($request->validated());

        if ($request->hasFile('file')) {
            $textbook->clearMediaCollection('file');

            $textbook->addMediaFromRequest('file')->toMediaCollection('file');
        }

        if ($request->hasFile('image')) {
            $textbook->clearMediaCollection('image');

            $textbook->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return new TextbookResource($textbook);
    }

    public function destroy(Textbook $textbook): JsonResponse
    {
        $textbook->delete();

        return response()->ok();
    }
}
