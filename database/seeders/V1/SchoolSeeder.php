<?php

namespace Database\Seeders\V1;

use App\Models\District;
use App\Models\Post;
use App\Models\Region;
use App\Models\School;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Common\Exception\UnsupportedTypeException;
use OpenSpout\Reader\Exception\ReaderNotOpenedException;
use Rap2hpoutre\FastExcel\FastExcel;

class SchoolSeeder extends Seeder
{
    /**
     * @throws IOException
     * @throws UnsupportedTypeException
     * @throws ReaderNotOpenedException
     */
    public function run(): void
    {
        (new FastExcel())->import(storage_path('app/schools.xlsx'), function ($line) {
            return School::create([
                'district_id' => $line['district_id'],
                'name' => [
                    'kaa' => $line['name_kaa'],
                    'uz' => $line['name_uz'],
                ],
            ]);
        });
    }
}
