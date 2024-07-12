<?php

namespace Database\Seeders;

use Database\Seeders\V1\AuthorSeeder;
use Database\Seeders\V1\DegreeSeeder;
use Database\Seeders\V1\InfoSeeder;
use Database\Seeders\V1\LessonSeeder;
use Database\Seeders\V1\PostSeeder;
use Database\Seeders\V1\PresentationSeeder;
use Database\Seeders\V1\QuizSeeder;
use Database\Seeders\V1\RegionSeeder;
use Database\Seeders\V1\SchoolSeeder;
use Database\Seeders\V1\TextbookSeeder;
use Database\Seeders\V1\UserSeeder;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RegionSeeder::class,
            SchoolSeeder::class,
            PostSeeder::class,
            UserSeeder::class,
            InfoSeeder::class,
            AuthorSeeder::class,
            DegreeSeeder::class,
            TextbookSeeder::class,
            QuizSeeder::class,
            LessonSeeder::class,
            PresentationSeeder::class,
        ]);
    }
}
