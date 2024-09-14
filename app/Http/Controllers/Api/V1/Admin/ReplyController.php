<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\StoreReplyRequest;
use App\Http\Requests\Api\V1\Admin\UpdateReplyRequest;
use App\Http\Resources\V1\Admin\ReplyResource;
use App\Models\Reply;
use Illuminate\Http\JsonResponse;

class ReplyController extends Controller
{
    public function store(StoreReplyRequest $request): ReplyResource
    {
        return new ReplyResource(Reply::create($request->validated()));
    }

    public function update(UpdateReplyRequest $request, Reply $reply): ReplyResource
    {
        return new ReplyResource(tap($reply)->update($request->validated()));
    }

    public function destroy(Reply $reply): JsonResponse
    {
        $reply->delete();

        return response()->ok();
    }
}
