<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Admin\PostCollection;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function index(Request $request): PostCollection
    {
        $posts = Cache::remember('posts_' . $request->getLocale(), now()->addHour(), function () {
            return Post::get();
        });
        return new PostCollection($posts);
    }
}
