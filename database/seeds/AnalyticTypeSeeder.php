<?php

use Illuminate\Database\Seeder;
use App\Models\AnalyticTypes;

class AnalyticTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('APP_ENV') == 'local' || env('APP_ENV') == 'testing') {
            $handle = fopen(storage_path('app/seeder/analyticsTypes.csv'), 'r');
            fgetcsv($handle, 1000, "\t");

            while (($analyticsType = fgetcsv($handle, 1000, "\t")) !== false) {
                AnalyticTypes::create([
                    'id' => $analyticsType[0],
                    'name' => $analyticsType[1],
                    'units' => $analyticsType[2],
                    'is_numeric' => (boolean)$analyticsType[3],
                    'num_decimal_places' => $analyticsType[4]
                ]);
            }

            fclose($handle);
        }
    }
}
