<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\NewsCategory;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Create admin user first
        $user = User::create([
            'name' => 'Admin MISADA',
            'email' => 'admin@misada.sch.id',
            'password' => bcrypt('password123'),
        ]);

        // Create news categories
        NewsCategory::create([
            'name' => 'Berita Umum',
            'slug' => 'berita-umum',
            'description' => 'Berita umum madrasah',
        ]);

        NewsCategory::create([
            'name' => 'Ekstrakurikuler',
            'slug' => 'ekstrakurikuler',
            'description' => 'Berita ekstrakurikuler dan lomba',
        ]);

        NewsCategory::create([
            'name' => 'Olahraga',
            'slug' => 'olahraga',
            'description' => 'Berita olahraga dan pertandingan',
        ]);

        NewsCategory::create([
            'name' => 'Akademik',
            'slug' => 'akademik',
            'description' => 'Berita akademik dan hasil belajar',
        ]);

        // Now run the other seeders
        $this->call([
            PagesSeeder::class,
            NewsSeeder::class,
            AnnouncementsSeeder::class,
            EventsSeeder::class,
            GalleriesSeeder::class,
            FacilitiesSeeder::class,
            TeachersSeeder::class,
            WebsiteSettingsSeeder::class,
        ]);
    }
}