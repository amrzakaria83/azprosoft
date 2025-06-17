<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Religion;
use App\Models\Country;
use App\Models\Zone;
use App\Models\Region;
use App\Models\City;
use App\Models\Setting;
use App\Models\Employee;
use App\Models\Site;

use App\Models\Job;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Setting::factory(1)->create();
        Employee::factory(1)->create();
        // Page::factory(1)->create();
        $this->call([
            
            PermissionSeeder::class,
            AdditionalPermissionSeeder::class,
            ModelHasRolesTableSeeder::class,
            GovernoratesTableSeeder::class,
            CitiesTableSeeder::class,
            CountriesTableSeeder::class,
            EmiratesTableSeeder::class,
            // for trying
            // AreasTableSeeder::class,
            // CentersTableSeeder::class,
            // ProductsTableSeeder::class,
            // TypeContactsTableSeeder::class,
            // SpecialtiesTableSeeder::class,
            // ContactsTableSeeder::class,

        ]);
    }
}
