<?php

use Illuminate\Database\Seeder;
use App\Models\PropertyAnalytics;

class PropertyAnalyticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('APP_ENV') == 'local' || env('APP_ENV') == 'testing') {
            $handle = fopen(storage_path('app/seeder/propertyAnalytics.csv'), 'r');
            fgetcsv($handle, 1000, "\t");

            while (($property = fgetcsv($handle, 1000, "\t")) !== false) {
                PropertyAnalytics::create([
                    'property_id' => $property[0],
                    'analytic_type_id' => $property[1],
                    'value' => $property[2]
                ]);
            }

            fclose($handle);
        }
    }
}
