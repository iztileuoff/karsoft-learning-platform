<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\StoreAuthorRequest;
use App\Http\Requests\Api\V1\Admin\UpdateAuthorRequest;
use App\Http\Resources\V1\Admin\AuthorCollection;
use App\Http\Resources\V1\Admin\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Request $request): AuthorCollection
    {
        $authors = Author::all();

        return new AuthorCollection($authors);
    }

    public function store(StoreAuthorRequest $request)
    {
        return new AuthorResource(Author::create($request->validated()));
    }

    public function show(Author $author)
    {
        return new AuthorResource($author);
    }

    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $author->update($request->validated());

        return new AuthorResource($author);
    }

    public function destroy(Author $author)
    {
        $author->delete();

        return response()->ok();
    }
}
