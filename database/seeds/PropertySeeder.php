<?php

use Illuminate\Database\Seeder;
use App\Models\Properties;
use Ramsey\Uuid\Uuid;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('APP_ENV') == 'local' || env('APP_ENV') == 'testing') {
            $handle = fopen(storage_path('app/seeder/property.csv'), 'r');
            fgetcsv($handle, 1000, "\t");

            while (($property = fgetcsv($handle, 1000, "\t")) !== false) {
                Properties::create([
                    'id' => $property[0],
                    'suburb' => $property[1],
                    'state' => $property[2],
                    'country' => $property[3],
                ]);
            }

            fclose($handle);
        }
    }
}
