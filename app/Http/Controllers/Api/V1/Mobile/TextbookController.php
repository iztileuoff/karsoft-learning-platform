<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Mobile\TextbookCollection;
use App\Http\Resources\V1\Mobile\TextbookResource;
use App\Models\Textbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TextbookController extends Controller
{
    public function index(Request $request): TextbookCollection
    {
        $textbooks = Cache::remember('textbooks', now()->addHour(), function () {
            return Textbook::with('media', 'degree')->get();
        });

        return new TextbookCollection($textbooks);
    }

    public function show(Textbook $textbook): TextbookResource
    {
        return new TextbookResource($textbook->load('media', 'degree'));
    }
}
