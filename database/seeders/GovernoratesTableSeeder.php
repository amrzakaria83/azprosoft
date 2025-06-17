<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GovernoratesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $governorates = [
            [1, 'القاهرة', 'Cairo', 'EGY'],
            [2, 'الجيزة', 'Giza', 'EGY'],
            [3, 'الأسكندرية', 'Alexandria', 'EGY'],
            [4, 'الدقهلية', 'Dakahlia', 'EGY'],
            [5, 'البحر الأحمر', 'Red Sea', 'EGY'],
            [6, 'البحيرة', 'Beheira', 'EGY'],
            [7, 'الفيوم', 'Fayoum', 'EGY'],
            [8, 'الغربية', 'Gharbiya', 'EGY'],
            [9, 'الإسماعلية', 'Ismailia', 'EGY'],
            [10, 'المنوفية', 'Menofia', 'EGY'],
            [11, 'المنيا', 'Minya', 'EGY'],
            [12, 'القليوبية', 'Qaliubiya', 'EGY'],
            [13, 'الوادي الجديد', 'New Valley', 'EGY'],
            [14, 'السويس', 'Suez', 'EGY'],
            [15, 'اسوان', 'Aswan', 'EGY'],
            [16, 'اسيوط', 'Assiut', 'EGY'],
            [17, 'بني سويف', 'Beni Suef', 'EGY'],
            [18, 'بورسعيد', 'Port Said', 'EGY'],
            [19, 'دمياط', 'Damietta', 'EGY'],
            [20, 'الشرقية', 'Sharkia', 'EGY'],
            [21, 'جنوب سيناء', 'South Sinai', 'EGY'],
            [22, 'كفر الشيخ', 'Kafr Al sheikh', 'EGY'],
            [23, 'مطروح', 'Matrouh', 'EGY'],
            [24, 'الأقصر', 'Luxor', 'EGY'],
            [25, 'قنا', 'Qena', 'EGY'],
            [26, 'شمال سيناء', 'North Sinai', 'EGY'],
            [27, 'سوهاج', 'Sohag', 'EGY'],
        ];

        foreach ($governorates as $governorate) {
            DB::table('governorates')->insert([
                'id' => $governorate[0],
                'governorate_name_ar' => $governorate[1],
                'governorate_name_en' => $governorate[2],
                'countrycodealpha3' => $governorate[3],
            ]);
        }
    }
}