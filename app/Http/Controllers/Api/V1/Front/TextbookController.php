<?php

namespace App\Http\Controllers\Api\V1\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Front\TextbookCollection;
use App\Http\Resources\V1\Front\TextbookResource;
use App\Models\Textbook;
use Illuminate\Http\Request;

class TextbookController extends Controller
{
    public function index(Request $request): TextbookCollection
    {
        $textbooks = Textbook::with('media', 'degree')->get();

        return new TextbookCollection($textbooks);
    }

    public function show(Textbook $textbook): TextbookResource
    {
        return new TextbookResource($textbook->load('media', 'degree'));
    }
}
