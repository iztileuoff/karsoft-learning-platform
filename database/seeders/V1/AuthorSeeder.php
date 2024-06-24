<?php

namespace Database\Seeders\V1;

use App\Models\Author;
use App\Models\Info;
use App\Models\Post;
use Illuminate\Database\Seeder;

use function Symfony\Component\Translation\t;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        Author::create([
            'first_name' => 'Venera',
            'last_name' => 'Allamuratova',
            'description' => [
                'kaa' => "Qaraqalpaqstan Respublikası Mektepke shekemgi hám mektep bilimlendiriw ministrligi janındaǵı Respublika bilimlendiriw orayınıń informatika páni metodisti.",
                'uz' => "Qoraqalpog'iston Respublikasi Maktabgacha va maktab ta'limi vazirligi huzuridagi Respublika ta'lim markazining informatika fani metodisti.",
            ],
        ]);

        Author::create([
            'first_name' => 'Ruslan',
            'last_name' => 'Jarılqaǵanov',
            'description' => [
                'kaa' => "Qaraqalpaqstan Respublikası Mektepke shekemgi hám mektep bilimlendiriw ministrligi Qanlıkól rayonı mektepke shekemgi hám mektep bilimlendiriw bólimine qaraslı 19-sanlı ayırım pánler tereń oqıtılatuǵın klassları bar ulıwma bilim beriw mektebiniń informatika hám informaciyalıq texnologiyaları páni muǵállimi.",
                'uz' => "Qoraqalpog'iston Respublikasi Maktabgacha va maktab taʼlimi vazirligi Qonliko'l tumani maktabgacha va maktab ta'limi bo'limiga tegishli 19-sonli alohida fanlarni chuqur o'qitish sinflari bo'lgan umumiy ta'lim berish maktabining informatika va axborot texnologiyalari fani o'qituvchisi.",
            ],
        ]);
    }
}
