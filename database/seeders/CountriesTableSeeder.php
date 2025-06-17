<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            [1, 'Egypt', 'مصر', 'EGY'],
            [2, 'United Arab Emirates', 'الإمارات العربية المتحدة', 'UAE'],
        ];

        foreach ($countries as $country) {
            DB::table('countries')->insert([
                'id' => $country[0],
                'name_en' => $country[1],
                'name_ar' => $country[2],
                'countrycodealpha3' => $country[3],
            ]);
        }
    }
}