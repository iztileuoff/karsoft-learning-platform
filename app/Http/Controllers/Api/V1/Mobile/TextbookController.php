<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Mobile\IndexTextbookRequest;
use App\Http\Resources\V1\Mobile\TextbookCollection;
use App\Http\Resources\V1\Mobile\TextbookResource;
use App\Models\Textbook;

class TextbookController extends Controller
{
    public function index(IndexTextbookRequest $request): TextbookCollection
    {
        $textbooks = Textbook::when($request->degree_id, function ($query) use ($request) {
            $query->where('degree_id', $request->degree_id);
        })->when($request->language, function ($query) use ($request) {
            $query->where('language', $request->language);
        })
            ->with('media', 'degree')
            ->get();

        return new TextbookCollection($textbooks);
    }

    public function show(Textbook $textbook): TextbookResource
    {
        return new TextbookResource($textbook->load('media', 'degree'));
    }
}
