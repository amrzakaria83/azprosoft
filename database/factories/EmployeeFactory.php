<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;
use App\Models\Religion;
use App\Models\Country;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'emp_code'=> 1,
        'name_ar'=> 'admin',
        'name_en'=> 'admin',
        'phone'=> 01001234567,
        'emailaz'=> 'az@az.com',
        'role_id'=> 1,
        'is_active'=> 1,
        'type'=> 0, 
        'password'=> Hash::make('123456789'),
        ];
    }
}
