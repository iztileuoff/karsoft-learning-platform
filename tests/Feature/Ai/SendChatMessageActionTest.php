<?php

namespace Tests\Feature\Ai;

use App\Actions\Ai\SendChatMessageAction;
use App\Contracts\Ai\ChatClientInterface;
use App\DTO\Ai\GeminiResponseData;
use App\DTO\Ai\SendChatMessageData;
use App\Enums\AiMessageStatus;
use App\Exceptions\Ai\GeminiException;
use App\Models\AiConversation;
use App\Models\AiMessage;
use App\Models\User;
use App\Services\Ai\ConversationContextBuilder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Mockery;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class SendChatMessageActionTest extends TestCase
{
    use DatabaseTransactions;

    private ChatClientInterface $mockClient;

    private SendChatMessageAction $action;

    private User $user;

    private AiConversation $conversation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockClient = Mockery::mock(ChatClientInterface::class);
        $this->action = new SendChatMessageAction(
            $this->mockClient,
            app(ConversationContextBuilder::class),
        );

        $this->user = User::factory()->create();
        $this->conversation = $this->user->aiConversations()->create(['source' => 'front']);
    }

    private function makeData(?string $clientId = null): SendChatMessageData
    {
        return new SendChatMessageData(
            message: 'Salom, test xabari',
            clientMessageId: $clientId ?? (string) Str::uuid(),
            source: 'front',
            conversationId: $this->conversation->id,
        );
    }

    private function successReply(string $text = 'Gemini javobi'): GeminiResponseData
    {
        return new GeminiResponseData(
            text: $text,
            model: 'gemini-2.0-flash',
            promptTokens: 10,
            completionTokens: 5,
            totalTokens: 15,
            finishReason: 'STOP',
            latencyMs: 200,
        );
    }

    /** Birinchi so'rov: user xabari + placeholder yaratiladi, Gemini chaqiriladi */
    public function test_fresh_request_calls_gemini_and_returns_completed(): void
    {
        $this->mockClient->expects('generate')->once()->andReturn($this->successReply());

        $data = $this->makeData();
        $result = $this->action->execute($this->user, $data);

        $this->assertEquals(AiMessageStatus::Completed, $result->status);
        $this->assertEquals('Gemini javobi', $result->content);

        // DB tekshiruvi: shu conversation uchun aynan 2 xabar (user + model)
        $this->assertCount(2, $this->conversation->messages()->get());
    }

    /** Bir xil client_message_id bilan takroriy so'rov: completed javob qaytadi, Gemini chaqirilmaydi */
    public function test_duplicate_request_returns_existing_completed_reply(): void
    {
        $this->mockClient->expects('generate')->once()->andReturn($this->successReply('Birinchi javob'));

        $data = $this->makeData('same-id-123');

        $first = $this->action->execute($this->user, $data);
        $this->assertEquals('Birinchi javob', $first->content);

        // Ikkinchi so'rov — Gemini chaqirilmasligi kerak (mock once = 1 ta chaqiruv)
        $second = $this->action->execute($this->user, $data);
        $this->assertEquals($first->id, $second->id);
        $this->assertEquals('Birinchi javob', $second->content);
    }

    /** Gemini xato bersa: placeholder Failed bo'ladi, xato qayta tashlanadi */
    public function test_gemini_failure_marks_placeholder_as_failed(): void
    {
        $this->mockClient->expects('generate')->once()
            ->andThrow(GeminiException::timeout());

        $data = $this->makeData();

        $this->expectException(GeminiException::class);
        $this->action->execute($this->user, $data);

        $placeholder = AiMessage::where('role', 'model')->first();
        $this->assertEquals(AiMessageStatus::Failed, $placeholder->status);
    }

    /** Failed placeholder bilan qayta so'rov: Gemini chaqiriladi (retry) */
    public function test_retry_after_failure_calls_gemini_again(): void
    {
        $clientId = 'retry-test-'.Str::uuid();

        // 1-urinish: xato
        $this->mockClient->expects('generate')->twice()
            ->andReturn($this->successReply('Retry javobi'));

        // 1-urinish muvaffaqiyatli (test uchun soddalashtiramiz)
        $data = $this->makeData($clientId);
        $first = $this->action->execute($this->user, $data);
        $this->assertEquals(AiMessageStatus::Completed, $first->status);

        // Placeholder'ni Failed qilib belgilaymiz (muvaffaqiyatsiz urinishni simulate qilamiz)
        $placeholder = $first;
        $placeholder->update(['status' => AiMessageStatus::Failed, 'content' => null, 'error' => 'Timeout']);

        // 2-urinish: placeholder Failed → Gemini chaqirilishi kerak
        $second = $this->action->execute($this->user, $data);
        $this->assertEquals(AiMessageStatus::Completed, $second->status);
        $this->assertEquals('Retry javobi', $second->content);
    }

    /** Fresh pending (< 2 daqiqa) bilan so'rov: 409 qaytishi kerak */
    public function test_pending_within_2_minutes_returns_409(): void
    {
        $clientId = 'pending-test-'.Str::uuid();

        // User xabarini va pending placeholder yaratamiz
        $userMessage = $this->conversation->messages()->create([
            'role' => 'user',
            'content' => 'Test',
            'status' => AiMessageStatus::Completed,
            'client_message_id' => $clientId,
        ]);
        $this->conversation->messages()->create([
            'role' => 'model',
            'status' => AiMessageStatus::Pending,
            'reply_to_id' => $userMessage->id,
        ]);

        $this->expectException(HttpException::class);

        $data = $this->makeData($clientId);
        $this->action->execute($this->user, $data);
    }

    /** Stale pending (>= 2 daqiqa) bilan so'rov: Gemini chaqiriladi */
    public function test_stale_pending_over_2_minutes_retries_gemini(): void
    {
        $clientId = 'stale-test-'.Str::uuid();
        $this->mockClient->expects('generate')->once()->andReturn($this->successReply('Stale retry'));

        $userMessage = $this->conversation->messages()->create([
            'role' => 'user',
            'content' => 'Test',
            'status' => AiMessageStatus::Completed,
            'client_message_id' => $clientId,
        ]);
        $placeholder = $this->conversation->messages()->create([
            'role' => 'model',
            'status' => AiMessageStatus::Pending,
            'reply_to_id' => $userMessage->id,
        ]);

        // Placeholder'ni 3 daqiqa eski qilib belgilaymiz
        \DB::table('ai_messages')
            ->where('id', $placeholder->id)
            ->update(['updated_at' => now()->subMinutes(3)]);

        $data = $this->makeData($clientId);
        $result = $this->action->execute($this->user, $data);

        $this->assertEquals(AiMessageStatus::Completed, $result->status);
        $this->assertEquals('Stale retry', $result->content);
    }
}
