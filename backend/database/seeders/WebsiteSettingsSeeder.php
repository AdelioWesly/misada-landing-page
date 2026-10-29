<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WebsiteSetting;

class WebsiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        WebsiteSetting::create([
            'key' => 'school_name',
            'value' => json_encode(['id' => 'Madrasah Aliyah MISADA', 'en' => 'MISADA Islamic High School']),
        ]);

        WebsiteSetting::create([
            'key' => 'tagline',
            'value' => json_encode(['id' => 'Membangun Madrasah Hebat Martabat', 'en' => 'Building Excellent Madrasah with Dignity']),
        ]);

        WebsiteSetting::create([
            'key' => 'logo_url',
            'value' => json_encode(['id' => '/logo-misada.png', 'en' => '/misada-logo.png']),
        ]);
    }
}