<?php

namespace Database\Seeders\V1;

use App\Enums\DistrictsEnum;
use App\Enums\PostsEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'is_admin' => true,
            'phone' => '998111111111',
            'email' => null,
            'password' => 'karsoft-76353',
            'post_id' => PostsEnum::teacher,
            'district_id' => DistrictsEnum::Nukus,
            'school_id' => 1,
            'google_id' => null,
            'telegram_id' => null,
        ]);
    }
}
