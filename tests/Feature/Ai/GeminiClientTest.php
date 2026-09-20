<?php

namespace Tests\Feature\Ai;

use App\Exceptions\Ai\GeminiException;
use App\Services\Ai\GeminiClient;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GeminiClientTest extends TestCase
{
    private GeminiClient $client;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'gemini.api_key' => 'test-secret-key',
            'gemini.model' => 'gemini-2.0-flash',
            'gemini.endpoint' => 'https://generativelanguage.googleapis.com/v1beta/models',
            'gemini.timeout' => 30,
            'gemini.connect_timeout' => 10,
            'gemini.retry_delay' => 0,  // testlarda uxlamaymiz
        ]);

        $this->client = new GeminiClient;
    }

    private function successPayload(string $text = 'Javob matni'): array
    {
        return [
            'candidates' => [[
                'content' => ['parts' => [['text' => $text]]],
                'finishReason' => 'STOP',
            ]],
            'modelVersion' => 'gemini-2.0-flash',
            'usageMetadata' => [
                'promptTokenCount' => 10,
                'candidatesTokenCount' => 5,
                'totalTokenCount' => 15,
            ],
        ];
    }

    /** API kaliti query string'da emas, header'da yuborilishi kerak */
    public function test_api_key_sent_as_header_not_query_param(): void
    {
        Http::fake([
            '*' => Http::response($this->successPayload(), 200),
        ]);

        $this->client->generate([['role' => 'user', 'parts' => [['text' => 'Salom']]]], 'System');

        Http::assertSent(function (Request $request) {
            $this->assertStringNotContainsString('test-secret-key', $request->url(), 'Kalit URL\'da bo\'lmasligi kerak');
            $this->assertEquals('test-secret-key', $request->header('x-goog-api-key')[0]);

            return true;
        });
    }

    /** Muvaffaqiyatli chaqiruvda to'g'ri GeminiResponseData qaytishi kerak */
    public function test_successful_response_returns_data(): void
    {
        Http::fake([
            '*' => Http::response($this->successPayload('Salom!'), 200),
        ]);

        $result = $this->client->generate([['role' => 'user', 'parts' => [['text' => 'Salom']]]], 'System');

        $this->assertEquals('Salom!', $result->text);
        $this->assertEquals(15, $result->totalTokens);
    }

    /** ConnectionException → GeminiException::timeout (504, ai_timeout) */
    public function test_connection_exception_becomes_timeout(): void
    {
        Http::fake(function () {
            throw new ConnectionException('cURL timeout');
        });

        $this->expectException(GeminiException::class);

        try {
            $this->client->generate([['role' => 'user', 'parts' => [['text' => 'test']]]], 'System');
        } catch (GeminiException $e) {
            $this->assertEquals(504, $e->getHttpStatus());
            $this->assertEquals('ai_timeout', $e->getErrorCode());
            $this->assertStringNotContainsString('test-secret-key', $e->getMessage(), 'Kalit xato xabarida bo\'lmasligi kerak');
            throw $e;
        }
    }

    /** 429 → quotaExceeded (503, ai_quota_exceeded), retry bo'lmasligi kerak */
    public function test_429_throws_quota_exceeded_without_retry(): void
    {
        Http::fake([
            '*' => Http::response(['error' => ['message' => 'Quota exceeded']], 429),
        ]);

        $this->expectException(GeminiException::class);

        try {
            $this->client->generate([['role' => 'user', 'parts' => [['text' => 'test']]]], 'System');
        } catch (GeminiException $e) {
            $this->assertEquals(503, $e->getHttpStatus());
            $this->assertEquals('ai_quota_exceeded', $e->getErrorCode());
            throw $e;
        }

        // Faqat bitta HTTP so'rov bo'lishi kerak — retry yo'q
        Http::assertSentCount(1);
    }

    /** 429 da retry bo'lmaydi — HTTP so'rov faqat bir marta jo'natiladi */
    public function test_429_sends_exactly_one_request(): void
    {
        Http::fake([
            '*' => Http::response(['error' => ['message' => 'Quota exceeded']], 429),
        ]);

        try {
            $this->client->generate([['role' => 'user', 'parts' => [['text' => 'test']]]], 'System');
        } catch (GeminiException) {
        }

        Http::assertSentCount(1);
    }

    /** 503 → retry bir marta, ikkinchisida ham 503 → overloaded (503, ai_overloaded) */
    public function test_503_retries_once_then_throws_overloaded(): void
    {
        Http::fakeSequence()
            ->push(['error' => ['message' => 'Service unavailable']], 503)
            ->push(['error' => ['message' => 'Service unavailable']], 503);

        $this->expectException(GeminiException::class);

        try {
            $this->client->generate([['role' => 'user', 'parts' => [['text' => 'test']]]], 'System');
        } catch (GeminiException $e) {
            $this->assertEquals(503, $e->getHttpStatus());
            $this->assertEquals('ai_overloaded', $e->getErrorCode());
            Http::assertSentCount(2);
            throw $e;
        }
    }

    /** 503 → retry → muvaffaqiyatli → natija qaytadi */
    public function test_503_then_success_on_retry(): void
    {
        Http::fakeSequence()
            ->push(['error' => ['message' => 'Overloaded']], 503)
            ->push($this->successPayload('Retry javob'), 200);

        $result = $this->client->generate([['role' => 'user', 'parts' => [['text' => 'test']]]], 'System');

        $this->assertEquals('Retry javob', $result->text);
        Http::assertSentCount(2);
    }

    /** Bo'sh text → GeminiException (ai_error) */
    public function test_empty_text_throws_exception(): void
    {
        Http::fake([
            '*' => Http::response([
                'candidates' => [[
                    'content' => ['parts' => [['text' => '']]],
                    'finishReason' => 'STOP',
                ]],
                'usageMetadata' => ['promptTokenCount' => 0, 'candidatesTokenCount' => 0, 'totalTokenCount' => 0],
            ], 200),
        ]);

        $this->expectException(GeminiException::class);
        $this->client->generate([['role' => 'user', 'parts' => [['text' => 'test']]]], 'System');
    }
}
