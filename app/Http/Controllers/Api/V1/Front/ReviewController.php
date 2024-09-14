<?php

namespace App\Http\Controllers\Api\V1\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Front\UpdateReviewRequest;
use App\Http\Requests\Api\V1\Front\StoreReviewRequest;
use App\Http\Resources\V1\Front\ReviewCollection;
use App\Http\Resources\V1\Front\ReviewResource;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request): ReviewCollection
    {
        $reviews = Review::where('creator_id', $request->user()->id)
            ->with('creator', 'reply.creator')
            ->orderBy('id', 'desc')
            ->paginate($request->input('per_page', 10));

        return new ReviewCollection($reviews);
    }

    public function store(StoreReviewRequest $request): ReviewResource
    {
        return new ReviewResource(Review::create($request->validated()));
    }

    public function update(UpdateReviewRequest $request, Review $review): ReviewResource
    {
        return new ReviewResource(tap($review)->update($request->validated()));
    }

    public function destroy(Review $review): JsonResponse
    {
        $review->delete();

        return response()->ok();
    }
}
