<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\House;
use Illuminate\Support\Facades\DB;
use SplFileObject;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = fopen(realpath('database/data.csv'), 'r');

        // we need to miss first line with headers in csv file
        $currentRow = 0;

        while (($data = fgetcsv($file)) !== false) {

            // check for first line
            $currentRow++;
            if ($currentRow == 1) continue;

            list($name, $price, $bedrooms, $bathrooms, $storeys, $garages) = $data;
            House::factory()->create([
                'name' => $name,
                'price' => $price,
                'bedrooms' => $bedrooms,
                'bathrooms' => $bathrooms,
                'storeys' => $storeys,
                'garages' => $garages
            ]);

        }

        fclose($file);
    }
}
