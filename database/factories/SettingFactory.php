<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_ar' => 'نظام تجريبي',
            'name_en' => 'demo system',
            'email' => 'info@company.com',
            'phone' => '01006287379',
            'whatsapp' => '201006287379',
            'address' => 'عنوان تجريبي عنوان تجريبي',
            'facebook' => 'facebook link',
            'keywords_ar' => 'كلمات دلاليه',
            'description_ar' => 'وصف النظام',
        ];
    }
}
