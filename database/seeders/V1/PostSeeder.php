<?php

namespace Database\Seeders\V1;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        Post::create([
            'name' => [
                'kaa' => "Oqıwshı",
                'uz' => "O'quvchi",
            ]
        ]);

        Post::create([
            'name' => [
                'kaa' => "Muǵállim",
                'uz' => "O'qituvchi",
            ]
        ]);
    }
}
