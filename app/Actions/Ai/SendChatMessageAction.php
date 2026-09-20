<?php

namespace App\Actions\Ai;

use App\Contracts\Ai\ChatClientInterface;
use App\DTO\Ai\SendChatMessageData;
use App\Enums\AiMessageRole;
use App\Enums\AiMessageStatus;
use App\Exceptions\Ai\GeminiException;
use App\Models\AiAttachment;
use App\Models\AiConversation;
use App\Models\AiMessage;
use App\Models\User;
use App\Services\Ai\ConversationContextBuilder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

final class SendChatMessageAction
{
    public function __construct(
        private readonly ChatClientInterface $client,
        private readonly ConversationContextBuilder $contextBuilder,
    ) {}

    public function execute(User $user, SendChatMessageData $data): AiMessage
    {
        $conversation = $this->resolveConversation($user, $data);

        [$placeholder, $shouldCallGemini] = $this->resolveState($user, $conversation, $data);

        if (! $shouldCallGemini) {
            return $placeholder;
        }

        return $this->callGemini($conversation, $placeholder);
    }

    /**
     * Xabar + placeholder holatini bitta short transaction ichida aniqlaydi.
     * Gemini chaqiruvi transaksiyadan TASHQARIDA — uzun HTTP kutish DB ulanishini band qilmasin.
     *
     * @return array{AiMessage, bool} [$placeholder, $shouldCallGemini]
     */
    private function resolveState(User $user, AiConversation $conversation, SendChatMessageData $data): array
    {
        return DB::transaction(function () use ($user, $conversation, $data): array {
            $userMessage = $conversation->messages()
                ->where('client_message_id', $data->clientMessageId)
                ->where('role', AiMessageRole::User)
                ->lockForUpdate()
                ->first();

            if (! $userMessage) {
                return $this->freshRequest($user, $conversation, $data);
            }

            $placeholder = $userMessage->reply()->lockForUpdate()->first();

            if (! $placeholder) {
                return [$this->createPendingPlaceholder($conversation, $userMessage), true];
            }

            return match ($placeholder->status) {
                AiMessageStatus::Completed => [$placeholder, false],
                AiMessageStatus::Failed => [$this->claimFailed($placeholder), true],
                AiMessageStatus::Pending => $this->claimOrRejectPending($placeholder),
            };
        });
    }

    /**
     * Yangi xabar — user message yaratishda unique conflict bo'lsa,
     * parallel so'rov allaqachon yaratgan deb bilib re-read qilamiz.
     *
     * @return array{AiMessage, bool}
     */
    private function freshRequest(User $user, AiConversation $conversation, SendChatMessageData $data): array
    {
        try {
            $userMessage = $this->createUserMessage($user, $conversation, $data);
        } catch (QueryException $e) {
            // Parallel so'rov bizdan oldin bir xil client_message_id bilan kiritgan
            throw_unless($e->errorInfo[1] === 1062, $e);

            $userMessage = $conversation->messages()
                ->where('client_message_id', $data->clientMessageId)
                ->where('role', AiMessageRole::User)
                ->lockForUpdate()
                ->firstOrFail();
        }

        $placeholder = $userMessage->reply()->lockForUpdate()->first()
            ?? $this->createPendingPlaceholder($conversation, $userMessage);

        if ($placeholder->wasRecentlyCreated) {
            return [$placeholder, true];
        }

        return match ($placeholder->status) {
            AiMessageStatus::Completed => [$placeholder, false],
            AiMessageStatus::Failed => [$this->claimFailed($placeholder), true],
            AiMessageStatus::Pending => $this->claimOrRejectPending($placeholder),
        };
    }

    /** Failed → Pending: keyingi Gemini urinishi uchun tayyorlaydi */
    private function claimFailed(AiMessage $placeholder): AiMessage
    {
        $placeholder->update(['status' => AiMessageStatus::Pending, 'error' => null]);

        return $placeholder;
    }

    /**
     * Pending placeholder:
     *  - updated_at < 2 daqiqa → boshqa jarayon ishlayapti, 409
     *  - updated_at >= 2 daqiqa → o'lgan jarayon, qayta ishga tushir
     *
     * @return array{AiMessage, bool}
     */
    private function claimOrRejectPending(AiMessage $placeholder): array
    {
        if ($placeholder->updated_at->diffInSeconds(now()) < 120) {
            abort(409, 'AI javobi hali tayyorlanmoqda.');
        }

        $placeholder->update(['status' => AiMessageStatus::Pending, 'error' => null]);

        return [$placeholder, true];
    }

    private function callGemini(AiConversation $conversation, AiMessage $placeholder): AiMessage
    {
        try {
            $reply = $this->client->generate(
                $this->contextBuilder->build($conversation),
                config('gemini.system_prompt'),
            );
        } catch (GeminiException $e) {
            $placeholder->update([
                'status' => AiMessageStatus::Failed,
                'error' => Str::limit($e->getMessage(), 1000),
            ]);
            throw $e;
        }

        $placeholder->update([
            'content' => $reply->text,
            'status' => AiMessageStatus::Completed,
            'model' => $reply->model,
            'prompt_tokens' => $reply->promptTokens,
            'completion_tokens' => $reply->completionTokens,
            'total_tokens' => $reply->totalTokens,
            'finish_reason' => $reply->finishReason,
            'latency_ms' => $reply->latencyMs,
        ]);

        return $placeholder;
    }

    private function createUserMessage(User $user, AiConversation $conversation, SendChatMessageData $data): AiMessage
    {
        $userMessage = $conversation->messages()->create([
            'role' => AiMessageRole::User,
            'content' => $data->message,
            'status' => AiMessageStatus::Completed,
            'client_message_id' => $data->clientMessageId,
        ]);

        $this->attachFiles($user, $userMessage, $data->attachmentIds);

        $conversation->fill([
            'last_message_at' => now(),
            'title' => $conversation->title ?: $this->titleFrom($data),
        ])->save();

        return $userMessage;
    }

    private function createPendingPlaceholder(AiConversation $conversation, AiMessage $userMessage): AiMessage
    {
        return $conversation->messages()->create([
            'role' => AiMessageRole::Model,
            'status' => AiMessageStatus::Pending,
            'reply_to_id' => $userMessage->id,
        ]);
    }

    private function resolveConversation(User $user, SendChatMessageData $data): AiConversation
    {
        if ($data->conversationId === null) {
            return $user->aiConversations()->create(['source' => $data->source]);
        }

        return $user->aiConversations()->findOrFail($data->conversationId);
    }

    /** @param array<int, int> $attachmentIds */
    private function attachFiles(User $user, AiMessage $message, array $attachmentIds): void
    {
        if ($attachmentIds === []) {
            return;
        }

        $attachments = AiAttachment::query()
            ->whereIn('id', $attachmentIds)
            ->where('user_id', $user->id)
            ->whereNull('ai_message_id')
            ->lockForUpdate()
            ->get();

        if ($attachments->count() !== count(array_unique($attachmentIds))) {
            throw ValidationException::withMessages([
                'attachment_ids' => __('Fayllardan biri topilmadi yoki allaqachon ishlatilgan.'),
            ]);
        }

        AiAttachment::query()
            ->whereIn('id', $attachments->pluck('id'))
            ->update(['ai_message_id' => $message->id]);
    }

    private function titleFrom(SendChatMessageData $data): string
    {
        return filled($data->message)
            ? Str::limit($data->message, 50)
            : __('Rasm bo\'yicha savol');
    }
}
