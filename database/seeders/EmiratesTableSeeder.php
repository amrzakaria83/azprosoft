<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmiratesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $emirates = [
            [1, 'Dubai', 'دبى', 'UAE'],
            [2, 'Abu Dhabi', 'أبوظبي', 'UAE'],
            [3, 'Sharjah', 'الشارقة', 'UAE'],
            [4, 'Al Ain', 'العين', 'UAE'],
            [5, 'Ajman', 'عجمان', 'UAE'],
            [6, 'Ras Al Khaimah', 'رأس الخيمة', 'UAE'],
            [7, 'Fujairah', 'الفجيرة', 'UAE'],
            [8, 'Umm Al Quwain', 'أم القيوين', 'UAE'],
        ];

        foreach ($emirates as $emirate) {
            DB::table('emirates')->insert([
                'id' => $emirate[0],
                'name_en' => $emirate[1],
                'name_ar' => $emirate[2],
                'countrycodealpha3' => $emirate[3],
            ]);
        }
    }
}