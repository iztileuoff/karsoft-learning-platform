<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Actions\Ai\SendChatMessageAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Front\SendChatMessageRequest;
use App\Http\Resources\V1\Mobile\AiConversationResource;
use App\Http\Resources\V1\Mobile\AiMessageResource;
use App\Models\AiConversation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GeminiChatController extends Controller
{
    public function __construct(private readonly SendChatMessageAction $action) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $conversations = $request->user()
            ->aiConversations()
            ->orderByDesc('last_message_at')
            ->paginate(20);

        return AiConversationResource::collection($conversations);
    }

    public function show(Request $request, AiConversation $conversation): AiConversationResource
    {
        abort_if($conversation->user_id !== $request->user()->id, 403);

        return new AiConversationResource($conversation->load('messages'));
    }

    public function store(SendChatMessageRequest $request): AiMessageResource
    {
        $reply = $this->action->execute(
            $request->user(),
            $request->toData(source: 'mobile'),
        );

        return new AiMessageResource($reply);
    }

    public function destroy(Request $request, AiConversation $conversation)
    {
        abort_if($conversation->user_id !== $request->user()->id, 403);

        $conversation->delete();

        return response()->ok();
    }
}
