<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\V1\PostSeeder;
use Database\Seeders\V1\RegionSeeder;
use Database\Seeders\V1\SchoolSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RegionSeeder::class,
            SchoolSeeder::class,
            PostSeeder::class,
        ]);
    }
}
