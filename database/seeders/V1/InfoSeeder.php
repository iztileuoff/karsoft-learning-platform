<?php

namespace Database\Seeders\V1;

use App\Models\Info;
use App\Models\Post;
use Illuminate\Database\Seeder;

use function Symfony\Component\Translation\t;

class InfoSeeder extends Seeder
{
    public function run(): void
    {
        Info::create([
            'text' => [
                'kaa' => "Test qaraqalpaqsha text",
                'uz' => "Test o'zbekcha text",
            ],
            'mobile' => true
        ]);

        Info::create([
            'text' => [
                'kaa' => "Test qaraqalpaqsha text",
                'uz' => "Test o'zbekcha text",
            ],
            'mobile' => false
        ]);
    }
}
