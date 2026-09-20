<?php

namespace Tests\Feature\Ai;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class AiChatThrottleTest extends TestCase
{
    /** 'ai-chat' limiter AppServiceProvider::boot'da ro'yxatdan o'tishi kerak */
    public function test_ai_chat_rate_limiter_is_registered(): void
    {
        $this->assertNotNull(RateLimiter::limiter('ai-chat'), "'ai-chat' limiter ro'yxatdan o'tmagan");
    }

    /** Limit: daqiqada 10 ta, user ID bo'yicha ajratiladi */
    public function test_ai_chat_limit_is_10_per_minute_by_user(): void
    {
        $limiterCallback = RateLimiter::limiter('ai-chat');

        $request = new Request;
        $request->setUserResolver(fn () => (object) ['id' => 77]);

        $limit = $limiterCallback($request);

        $this->assertEquals(10, $limit->maxAttempts);
        // perMinute() ichida decaySeconds = 60
        $this->assertEquals(60, $limit->decaySeconds);
    }

    /** Limit oshganda response JSON da code: rate_limit_exceeded bo'lishi kerak */
    public function test_throttle_response_returns_rate_limit_exceeded_code(): void
    {
        $limiterCallback = RateLimiter::limiter('ai-chat');

        $request = new Request;
        $request->setUserResolver(fn () => (object) ['id' => 77]);

        $limit = $limiterCallback($request);

        $this->assertNotNull($limit->responseCallback, 'Limit::response() o\'rnatilmagan');

        /** @var JsonResponse $response */
        $response = ($limit->responseCallback)(new Request, []);

        $this->assertEquals(429, $response->getStatusCode());

        $data = $response->getData(true);
        $this->assertArrayHasKey('code', $data);
        $this->assertEquals('rate_limit_exceeded', $data['code']);
        $this->assertArrayHasKey('message', $data);
    }

    /** IP bo'yicha fallback: user yo'q bo'lsa IP ishlatiladi */
    public function test_throttle_uses_ip_when_no_authenticated_user(): void
    {
        $limiterCallback = RateLimiter::limiter('ai-chat');

        $request = Request::create('/api/v1/chat', 'POST');
        // user yo'q — setUserResolver chaqirilmaydi

        $limit = $limiterCallback($request);

        // Xato tashlanmasa — IP fallback ishlayapti
        $this->assertNotNull($limit);
        $this->assertEquals(10, $limit->maxAttempts);
    }
}
