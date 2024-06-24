<?php

namespace Database\Seeders\V1;

use App\Models\District;
use App\Models\Post;
use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        $contents = File::get(storage_path('app/regions.json'));
        $data = json_decode(json: $contents, associative: true);

        $regions =  $data['regions'];

        foreach ($regions as $region) {
            Region::create([
                'name' => [
                    'kaa' => $region['name']['kaa'],
                    'uz' => $region['name']['uz'],
                ],
            ]);
        }

        $districts = $data['districts'];

        foreach ($districts as $district) {
            District::create([
                'region_id' => $district['region_id'],
                'name' => [
                    'kaa' => $district['name']['kaa'],
                    'uz' => $district['name']['uz'],
                ],
            ]);
        }
    }
}
