# Changes Log

All code modifications made to this project are recorded here in chronological order.

---

## 2026-09-07 — Subjects jadvaliga Informatika va Matematika qo'shildi

### Yangi fayllar (created)

**`database/seeders/V1/SubjectSeeder.php`**
- `firstOrCreate` orqali "Informatika" va "Matematika" yozuvlarini qo'shadigan seeder yaratildi

### O'zgartirilgan fayllar (modified)

**`database/seeders/DatabaseSeeder.php`**
- `SubjectSeeder::class` import va `$this->call()` ro'yxatiga qo'shildi

**Sabab:** Subjects jadvalini boshlang'ich ma'lumot bilan to'ldirish kerak edi.

---

## 2026-09-02 — Gemini Flash Chat API integratsiyasi

### Yangi fayllar (created)

| Fayl | Tavsif |
|------|--------|
| `app/Enums/AiMessageRole.php` | `user` / `model` roli enum |
| `app/Enums/AiMessageStatus.php` | `pending` / `completed` / `failed` status enum |
| `app/Exceptions/Ai/GeminiException.php` | Gemini API xatoliklari uchun exception |
| `app/Contracts/Ai/ChatClientInterface.php` | AI client interfeysi |
| `app/DTO/Ai/GeminiResponseData.php` | Gemini javob DTO |
| `app/DTO/Ai/SendChatMessageData.php` | Xabar yuborish DTO |
| `app/Models/AiConversation.php` | Suhbat modeli (user bilan bog'liq) |
| `app/Models/AiMessage.php` | Xabar modeli (role, status, token ma'lumotlari) |
| `app/Models/AiAttachment.php` | Fayl biriktirma modeli |
| `app/Services/Ai/GeminiClient.php` | Gemini Flash REST API klienti |
| `app/Services/Ai/ConversationContextBuilder.php` | Suhbat kontekstini Gemini formatiga o'giruvchi |
| `config/gemini.php` | Gemini konfiguratsiyasi (api_key, model, system_prompt) |
| `app/Http/Requests/Api/V1/Front/SendChatMessageRequest.php` | Xabar yuborish so'rovi validatori |
| `app/Http/Resources/V1/Front/AiConversationResource.php` | Suhbat JSON resursi (front) |
| `app/Http/Resources/V1/Front/AiMessageResource.php` | Xabar JSON resursi (front) |
| `app/Http/Resources/V1/Mobile/AiConversationResource.php` | Suhbat JSON resursi (mobile) |
| `app/Http/Resources/V1/Mobile/AiMessageResource.php` | Xabar JSON resursi (mobile) |
| `database/migrations/2026_09_02_000001_create_ai_conversations_table.php` | ai_conversations jadvali |
| `database/migrations/2026_09_02_000002_create_ai_messages_table.php` | ai_messages jadvali |
| `database/migrations/2026_09_02_000003_create_ai_attachments_table.php` | ai_attachments jadvali |

### O'zgartirilgan fayllar (modified)

| Fayl | O'zgarish |
|------|-----------|
| `app/Http/Controllers/Api/V1/Front/GeminiChatController.php` | Bo'sh shelldan to'liq controller (index/show/store/destroy) |
| `app/Http/Controllers/Api/V1/Mobile/GeminiChatController.php` | Bo'sh shelldan to'liq controller |
| `app/Models/User.php` | `aiConversations()` HasMany relatsiyasi qo'shildi |
| `app/Providers/AppServiceProvider.php` | `ChatClientInterface → GeminiClient` binding qo'shildi |
| `routes/api/v1/front.php` | `/chat` marshrutlari qo'shildi |
| `routes/api/v1/mobile.php` | `/mobile/chat` marshrutlari qo'shildi |
| `routes/console.php` | 1 oydan eski AI suhbatlarni kunlik tozalash schedule |
| `bootstrap/app.php` | `GeminiException` uchun 502 xato handler |
| `.env.example` | `GEMINI_API_KEY`, `GEMINI_MODEL` va boshq. o'zgaruvchilar |

### API Endpoints

**Front (auth:sanctum, ability:front):**
- `GET  /api/v1/chat` — suhbatlar ro'yxati (paginated)
- `POST /api/v1/chat` — yangi xabar yuborish (conversation_id yo'q bo'lsa yangi suhbat ochiladi)
- `GET  /api/v1/chat/{id}` — suhbat va barcha xabarlari
- `DELETE /api/v1/chat/{id}` — suhbatni o'chirish

**Mobile (auth:sanctum, ability:mobile):**
- `GET  /api/v1/mobile/chat`
- `POST /api/v1/mobile/chat`
- `GET  /api/v1/mobile/chat/{id}`
- `DELETE /api/v1/mobile/chat/{id}`

---

## 2026-09-02 — ConversationContextBuilder: rasm support

**`app/Services/Ai/ConversationContextBuilder.php`**

**Muammo:** Attachmentlar DB da saqlanardi, lekin Gemini'ga faqat matn (`'parts' => [['text' => ...]]`) yuborilardi. Rasm yuborilmagan — Gemini uni ko'rmagan.

**To'g'rilash:**
- `->with('attachments')` qo'shildi — N+1 oldini oladi
- `buildParts()` metodi: matn + har bir rasm uchun `inlineData` (base64) Gemini formatida qo'shiladi
- Faqat `image/*` mime turlari yuboriladi — PDF/txt kabi katta fayllar o'tkazib yuboriladi
- Fayl diskda yo'q bo'lsa — jimgina o'tkazib yuboriladi

**Gemini'ga yuboriladigan format (oldin → keyin):**
```json
// OLDIN
"parts": [{ "text": "Bu rasmdagi nima bor?" }]

// KEYIN
"parts": [
  { "text": "Bu rasmdagi nima bor?" },
  { "inlineData": { "mimeType": "image/jpeg", "data": "<base64>" } }
]
```

---

## 2026-09-02 — AlwaysAcceptJsonMiddleware fix

**`app/Http/Middleware/Api/V1/AlwaysAcceptJsonMiddleware.php`**

**Muammo:** `$request->header('Accept', ...)` — bu getter, header aslida o'rnatilmas edi. Natijada Sanctum auth middleware JSON so'rovni ko'rmay, 302 redirect qaytarardi.

**To'g'rilash:** `$request->headers->set('Accept', 'application/json')` — bu haqiqiy setter.

`Content-Type` o'rnatishni ham olib tashlandi — middleware `multipart/form-data` so'rovlarini buzib qo'yishi mumkin edi.

---

## 2026-09-02 — Attachment upload endpoint

### Yangi fayllar

| Fayl | Tavsif |
|------|--------|
| `app/Http/Requests/Api/V1/Front/UploadAttachmentRequest.php` | Fayl yuklash validatsiyasi (max 10MB, ruxsat etilgan mime turlari) |
| `app/Actions/Ai/UploadAttachmentAction.php` | Faylni `public` diskga saqlash va `AiAttachment` yozuvi yaratish |
| `app/Http/Resources/V1/Front/AiAttachmentResource.php` | Attachment JSON resursi (front) |
| `app/Http/Resources/V1/Mobile/AiAttachmentResource.php` | Attachment JSON resursi (mobile) |
| `app/Http/Controllers/Api/V1/Front/AiAttachmentController.php` | Front attachment controller |
| `app/Http/Controllers/Api/V1/Mobile/AiAttachmentController.php` | Mobile attachment controller |

### O'zgartirilgan fayllar

| Fayl | O'zgarish |
|------|-----------|
| `routes/api/v1/front.php` | `POST chat/attachments` route qo'shildi |
| `routes/api/v1/mobile.php` | `POST mobile/chat/attachments` route qo'shildi |

### Endpoints

- `POST /api/v1/chat/attachments` (auth:sanctum, ability:front)
- `POST /api/v1/mobile/chat/attachments` (auth:sanctum, ability:mobile)

**Request:** `multipart/form-data`, `file` maydoni (max 10MB, jpg/jpeg/png/gif/webp/pdf/txt/doc/docx)

**Response:**
```json
{
  "data": {
    "id": 15,
    "original_name": "rasm.jpg",
    "mime_type": "image/jpeg",
    "size": 204800,
    "url": "http://localhost/storage/ai-attachments/1/uuid.jpg",
    "created_at": "2026-09-02 10:00:00"
  }
}
```

**Sabab:** Foydalanuvchi xabar yuborishdan oldin fayl yuklashi va qaytgan `id` ni `attachment_ids` massiviga qo'shishi kerak.

---

## 2026-09-02 — GeminiClient retry logika

### O'zgartirilgan fayl

**`app/Services/Ai/GeminiClient.php`**

**O'zgarish:** "high demand" / 503 / 429 xatolarida avtomatik qayta urinish (3 marta, exponential backoff: 2s → 4s)

**Oldingi kod:**
```php
$response = Http::timeout(...)->post(...);
if (!$response->successful()) {
    throw new GeminiException("Gemini API xatosi: {$errorMessage}");
}
```

**Yangi kod:**
```php
for ($attempt = 1; $attempt <= 3; $attempt++) {
    $response = Http::timeout(...)->post(...);
    if ($response->successful()) break;
    // retry faqat 5xx, 429, yoki "high demand" uchun
    usleep($attempt * 2_000_000); // 2s, 4s
}
```

**Sabab:** `gemini-2.0-flash` model ba'zan "high demand" xatosi (503) qaytaradi. Bu vaqtinchalik Google tomonidagi yuklama muammosi — bir necha soniya kutib qayta urinish yetarli.

---

## [2026-09-01] Fix 404 on root route

**File Path:** `routes/web.php`

**Type of Change:** Modified

**Previous Code:**
```php
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

Route::get('/', function () {
    throw new NotFoundHttpException();
})->name('login');
```

**New Code:**
```php
Route::get('/', function () {
    return response()->json(['message' => 'Karsoft Learning Platform API']);
});
```

**Reasoning:**
The root route `/` was explicitly throwing a `NotFoundHttpException`, which caused every request to `http://127.0.0.1:8000/` to return a 404. The route was also incorrectly named `login`, which would cause Laravel's auth middleware to redirect unauthenticated users into a 404 instead of a real login page. Since this is an API-only project (all real routes live under `routes/api/`), the root was fixed to return a JSON welcome response. The now-unused `NotFoundHttpException` import was also removed.

---

---

## 2026-09-07

### CREATED: `app/Console/Commands/AiPruneHistoryCommand.php`
**Type:** New file

**Reasoning:**
Eski `routes/console.php` dagi anonymous `Schedule::call` faqat DB yozuvlarini o'chirardi — storage dagi fizik fayllar va `ai_attachments` yozuvlari qolib ketardi. Dedicated Artisan command yaratildi:
1. Eski conversationlar ga tegishli attachment pathlarini oladi
2. Conversationlarni o'chiradi (cascade: ai_messages ham o'chadi, ai_attachments.ai_message_id NULL bo'ladi)
3. Storage::disk('public') dan fizik fayllarni o'chiradi
4. `ai_message_id IS NULL` bo'lgan orphaned attachment yozuvlari va ularning fayllarini ham tozalaydi

---

### UPDATED: `routes/console.php`
**Type:** Refactor

**Before:**
```php
use App\Models\AiConversation;
...
Schedule::call(function () {
    $months = config('gemini.history_months', 1);
    AiConversation::where('last_message_at', '<', now()->subMonths($months))
        ->orWhere(...)->delete();
})->daily()->name('ai:prune-history');
```

**After:**
```php
Schedule::command('ai:prune-history')->daily()->name('ai:prune-history')->withoutOverlapping();
```

**Reasoning:**
Anonymous closure o'rniga dedicated Artisan command ishlatildi. `withoutOverlapping()` qo'shildi — agar avvalgi run hali tugamagan bo'lsa, yangi run boshlanmaydi.

---

## 2026-09-20 — 1-qadam: Gemini kalit header'ga + ConnectionException + timeout/retry

### Modified: `app/Exceptions/Ai/GeminiException.php`
**Before:** `final class GeminiException extends RuntimeException {}`
**After:** Named constructor'lar (`timeout`, `overloaded`, `quotaExceeded`), `httpStatus`, `errorCode` property'lari qo'shildi.
**Reasoning:** Turli Gemini xato turlari uchun to'g'ri HTTP status va machine-readable `code` (ai_timeout, ai_overloaded, ai_quota_exceeded) qaytarish uchun.

### Modified: `app/Services/Ai/GeminiClient.php`
**Before:** `->post("{$endpoint}?key={$apiKey}", ...)`, 3 urinish, 60s timeout, ConnectionException ushlashsiz.
**After:** `->withHeaders(['x-goog-api-key' => ...])`, 2 urinish, 30s timeout, 10s connectTimeout, 429 retry yo'q, ConnectionException → GeminiException::timeout().
**Reasoning:** Kalit cURL xato matniga (logga) tushmasligi; 429 retry qilish quota'ni tezroq tugataveradi; timeout qisqartirildi — shared hosting DB ulanishini band qilmaslik uchun.

### Modified: `config/gemini.php`
**Before:** `'timeout' => 60` (bitta qiymat).
**After:** `timeout=30`, `connect_timeout=10`, `retry_delay=3` qo'shildi (env orqali boshqariladi).
**Reasoning:** Testlarda `retry_delay=0` qilib uxlamaslik uchun; production'da mustaqil tuning imkoniyati.

### Modified: `bootstrap/app.php`
**Before:** `response()->json(['message' => ...], 502)` — har doim 502.
**After:** `['message' => ..., 'code' => ...]` + `$e->getHttpStatus()` — 502/503/504 to'g'ri kodlar.
**Reasoning:** Klient xato turini (quota/overload/timeout) farqlay olishi uchun.

### Created: `tests/Feature/Ai/GeminiClientTest.php`
8 test: header tekshiruvi, ConnectionException→504, 429→503(no retry), 503→retry→503, 503→retry→success, bo'sh javob.

---

## 2026-09-20 — 2-qadam: Telescope production'da o'chirildi

### Modified: `config/telescope.php`
**Before:** `'enabled' => env('TELESCOPE_ENABLED', true)`
**After:** `'enabled' => env('TELESCOPE_ENABLED', false)`
**Reasoning:** Production'da TELESCOPE_ENABLED o'rnatilmasa ham Telescope o'chirilgan bo'lishi kerak.

### Modified: `bootstrap/providers.php`
**Before:** `TelescopeServiceProvider::class` doim ro'yxatda.
**After:** Ro'yxatdan olib tashlandi — shartli holda AppServiceProvider ichidan register qilinadi.

### Modified: `app/Providers/AppServiceProvider.php`
**Added:** `register()` da `if (local && telescope.enabled) { register(TelescopeServiceProvider) }`.
**Reasoning:** Provider faqat `APP_ENV=local` va `TELESCOPE_ENABLED=true` da yuklanadi — production'da DB yozuvlari bo'lmaydi.

### Modified: `routes/console.php`
**Added:** `telescope:prune --hours=48` schedule (faqat telescope yoqilganda, `03:30` da).
**Reasoning:** Prune bo'lmasa telescope_entries cheksiz o'sgan bo'lar edi.

### Modified: `.env.example`
**Added:** `TELESCOPE_ENABLED=false` — production server uchun to'g'ri default.

### Created: `tests/Feature/Ai/TelescopeConfigTest.php`
3 test: config default falsy, testing muhitida provider yuklanmagan, local emas muhitda enabled=true bo'lsa ham yuklanmaydi.

---

## 2026-09-20 — 3-qadam: Session muammosi tahlili va SESSION_DRIVER tavsiyasi

### Tahlil natijasi (kod o'zgartirilmadi)
- API route'larida (`routes/api/v1/`) `StartSession` middleware hech qachon bo'lmagan — muammo allaqachon to'g'ri edi.
- `sessions` jadvalidagi DB so'rovlar Telescope'ning `web` middleware guruhidan kelgan (2-qadamda tuzatildi).
- `SANCTUM_STATEFUL_DOMAINS` o'rnatilmagan → Sanctum stateful auth ishlamaydi → qo'shimcha session yo'q.

### Modified: `.env.example`
**Before:** `SESSION_DRIVER=database`
**After:** `SESSION_DRIVER=file` (izoh bilan)
**Reasoning:** App sof API, sessions ishlatilmaydi. `file` driveri MySQL yukini kamaytiradi.

---

## 2026-09-20 — 5-qadam: Throttle (ai-chat, 10/daqiqa)

### Modified: `app/Providers/AppServiceProvider.php`
**Added (boot):** `RateLimiter::for('ai-chat', ...)` — 10/daqiqa, user ID bo'yicha (IP fallback), `Limit::response()` bilan JSON `{code: rate_limit_exceeded}`.
**Reasoning:** ThrottleRequestsException tashlanmaydi — Limit::response() to'g'ridan-to'g'ri 429 qaytaradi, Retry-After headerlari saqlanadi.

### Modified: `routes/api/v1/front.php`, `routes/api/v1/mobile.php`
**Added:** `->middleware('throttle:ai-chat')` faqat `store` route'da.
**Reasoning:** Suhbat ro'yxati va ko'rish throttle'ga tushmasin — faqat xabar yuborish cheklandi.

### Modified: `.env.example`
**Added:** `CACHE_STORE=file` (tavsiya) — throttle cache'ni DB'dan fayl tizimiga ko'chiradi, MySQL yukini kamaytiradi.

### Created: `tests/Feature/Ai/AiChatThrottleTest.php`
4 test: limiter ro'yxatda, 10/min limit, rate_limit_exceeded kodi, IP fallback.

---

## 2026-09-20 — 6-qadam: Idempotentlik, parallel himoya, Stringable bug

### Modified: `app/Http/Requests/Api/V1/Front/SendChatMessageRequest.php`
**Before:** `$this->string('client_message_id') ?: uuid` (Stringable doim truthy → uuid hech qachon ishlamagan)
**After:** `(string) $this->string('client_message_id') ?: uuid`

### Modified: `app/Actions/Ai/SendChatMessageAction.php`
To'liq qayta yozildi. Asosiy o'zgarishlar:
- `resolveState()`: lockForUpdate bilan bitta short transaction — barcha holatlar ichida hal qilinadi
- `freshRequest()`: unique 1062 xato ushlash + re-read (parallel race himoyasi)
- `claimFailed()`: Failed → Pending, Gemini'ga boradi
- `claimOrRejectPending()`: updated_at < 120s → 409; >=120s → stale, qayta urinadi
- `callGemini()`: Gemini chaqiruvi transaksiyadan tashqarida, xato → Failed

**Reasoning:**
- Eski kod: `existingReply()` faqat Completed ni tekshirardi, Failed holati unique constraint'ga urilardi
- Yangi kod: barcha holatlar (Completed/Failed/Pending/stale) lockForUpdate ichida atomik boshqariladi
- Parallel so'rovlar: 1062 ushlash + 409 bilan toza hal qilinadi

### Created: `tests/Feature/Ai/SendChatMessageActionTest.php`
6 test (DatabaseTransactions): fresh, duplicate, failure→failed, retry after failed, pending→409, stale→retry.
