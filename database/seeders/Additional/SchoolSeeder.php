<?php

namespace Database\Seeders\Additional;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 100; $i++) {
            School::create([
                'district_id' => null,
                'name' => [
                    'kaa' => "{$i}-mektep",
                    'uz' => "{$i}-maktab",
                ],
            ]);
        }
    }
}
