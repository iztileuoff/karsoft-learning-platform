<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\UpdateReviewRequest;
use App\Http\Resources\V1\Admin\ReviewCollection;
use App\Http\Resources\V1\Admin\ReviewResource;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request): ReviewCollection
    {
        $reviews = Review::with('creator', 'reply.creator')
            ->orderBy('id', 'desc')
            ->paginate($request->input('per_page', 10));

        return new ReviewCollection($reviews);
    }

    public function show(Review $review): ReviewResource
    {
        return new ReviewResource($review);
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
