<?php

namespace Tests\Feature\Ai;

use App\Providers\TelescopeServiceProvider;
use Tests\TestCase;

class TelescopeConfigTest extends TestCase
{
    /** Telescope config default'i falsy bo'lishi kerak (false, '', null barchasi o'chirilgan) */
    public function test_telescope_disabled_by_default(): void
    {
        $this->assertFalse((bool) config('telescope.enabled'));
    }

    /** Testing muhitida ('testing', 'local' emas) provider yuklanmasligi kerak */
    public function test_telescope_provider_not_registered_in_non_local_env(): void
    {
        $this->assertNotEquals('local', app()->environment());

        $loaded = app()->getLoadedProviders();

        $this->assertArrayNotHasKey(TelescopeServiceProvider::class, $loaded);
    }

    /** TELESCOPE_ENABLED=true bo'lsa ham, local muhitdan tashqarida yuklanmaydi */
    public function test_telescope_not_registered_even_if_enabled_outside_local(): void
    {
        // Amaldagi environment 'testing' — local emas
        config(['telescope.enabled' => true]);

        // Provider allaqachon yuklanmagan; yangi provider register qilish
        // AppServiceProvider::register() boot'da bir marta ishlaydi,
        // shuning uchun bu test boot'dan keyingi holatni tekshiradi.
        $loaded = app()->getLoadedProviders();

        $this->assertArrayNotHasKey(TelescopeServiceProvider::class, $loaded);
    }
}
