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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Butun chat logikasi shu yerda. Web va mobile controller'lar
 * faqat shu action'ni chaqiradi — kod ikki joyda takrorlanmaydi.
 */
final class SendChatMessageAction
{
    public function __construct(
        private readonly ChatClientInterface $client,
        private readonly ConversationContextBuilder $contextBuilder,
    ) {
    }

    public function execute(User $user, SendChatMessageData $data): AiMessage
    {
        $conversation = $this->resolveConversation($user, $data);

        // Tarmoq uzilib front so'rovni takrorlasa, Gemini'ga ikkinchi marta bormaymiz.
        if ($reply = $this->existingReply($conversation, $data->clientMessageId)) {
            return $reply;
        }

        // Yozuvlar alohida commit qilinadi. Gemini so'rovi tranzaksiyadan TASHQARIDA —
        // 30 soniyalik HTTP chaqiruv DB ulanishini band qilib turmasligi kerak.
        $placeholder = DB::transaction(function () use ($user, $conversation, $data): AiMessage {
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

            return $conversation->messages()->create([
                'role' => AiMessageRole::Model,
                'status' => AiMessageStatus::Pending,
                'reply_to_id' => $userMessage->id,
            ]);
        });

        try {
            $reply = $this->client->generate(
                $this->contextBuilder->build($conversation),
                config('gemini.system_prompt'),
            );
        } catch (GeminiException $e) {
            // Foydalanuvchi xabari bazada qoladi — nima so'raganini bilamiz va qayta urina olamiz.
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

    private function resolveConversation(User $user, SendChatMessageData $data): AiConversation
    {
        if ($data->conversationId === null) {
            return $user->aiConversations()->create(['source' => $data->source]);
        }

        // findOrFail user'ning o'z suhbatlari ichidan qidiradi —
        // begona conversation_id yuborilsa 404 qaytadi.
        return $user->aiConversations()->findOrFail($data->conversationId);
    }

    private function existingReply(AiConversation $conversation, string $clientMessageId): ?AiMessage
    {
        $userMessage = $conversation->messages()
            ->where('client_message_id', $clientMessageId)
            ->first();

        return $userMessage?->reply()
            ->where('status', AiMessageStatus::Completed)
            ->first();
    }

    /** @param  array<int, int>  $attachmentIds */
    private function attachFiles(User $user, AiMessage $message, array $attachmentIds): void
    {
        if ($attachmentIds === []) {
            return;
        }

        $attachments = AiAttachment::query()
            ->whereIn('id', $attachmentIds)
            ->where('user_id', $user->id)      // egalik tekshiruvi
            ->whereNull('ai_message_id')       // bir fayl faqat bir marta ishlatiladi
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