<?php

namespace Database\Seeders\V1;

use App\Models\Degree;
use Illuminate\Database\Seeder;

class DegreeSeeder extends Seeder
{
    public function run(): void
    {
        Degree::create(['name' => ['kaa' => "5-klass", 'uz' => "5-sinf"]]);
        Degree::create(['name' => ['kaa' => "6-klass", 'uz' => "6-sinf"]]);
        Degree::create(['name' => ['kaa' => "7-klass", 'uz' => "7-sinf"]]);
        Degree::create(['name' => ['kaa' => "8-klass", 'uz' => "8-sinf"]]);
        Degree::create(['name' => ['kaa' => "9-klass", 'uz' => "9-sinf"]]);
        Degree::create(['name' => ['kaa' => "10-klass", 'uz' => "10-sinf"]]);
        Degree::create(['name' => ['kaa' => "11-klass", 'uz' => "11-sinf"]]);
    }
}
