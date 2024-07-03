<?php

namespace Database\Seeders\V1;

use App\Models\Author;
use Illuminate\Database\Seeder;

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
    }
}
