<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Mobile\AuthorCollection;
use App\Http\Resources\V1\Mobile\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AuthorController extends Controller
{
    public function index(Request $request): AuthorCollection
    {
        $authors = Cache::remember('authors_' . app()->getLocale(), now()->addHour(), function () {
            return Author::get();
        });

        return new AuthorCollection($authors);
    }

    public function show(Author $author)
    {
        return new AuthorResource($author);
    }
}
