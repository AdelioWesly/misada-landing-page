<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class EventsSeeder extends Seeder
{
    public function run(): void
    {
        Event::create([
            'title' => 'Hari Bhakti Masyarakat',
            'slug' => 'hari-bhakti-masyarakat',
            'summary' => 'Acara bhakti masyarakat bulanan',
            'body' => 'Madrasah MISADA menggelar acara bhakti masyarakat berkala setiap bulan untuk mendekatkan diri kepada masyarakat sekitar.',
            'status' => 'published',
            'published_at' => now()->subDays(45),
            'starts_at' => now()->addDays(30),
            'ends_at' => now()->addDays(30)->addHour(4),
            'location' => 'Gedung Utama Madrasah',
            'registration_url' => null,
        ]);

        Event::create([
            'title' => 'Hari Sport',
            'slug' => 'hari-sport',
            'summary' => 'Acara olahraga antar kelas',
            'body' => 'Acara olahraga antar kelas akan dilaksanakan pada 10 Desember 2024 di lapangan madrasah.',
            'status' => 'published',
            'published_at' => now()->subDays(60),
            'starts_at' => now()->addDays(45),
            'ends_at' => now()->addDays(45)->addHour(6),
            'location' => 'Lapangan Madrasah',
            'registration_url' => null,
        ]);

        Event::create([
            'title' => 'Masa Lulusan',
            'slug' => 'masa-lulusan',
            'summary' => 'Konser hari lulusan kelas 12',
            'body' => 'Acara konser dan rapat liburan untuk kelas 12 yang akan dinikmati bersama keluarga.',
            'status' => 'published',
            'published_at' => now()->subDays(90),
            'starts_at' => now()->addDays(60),
            'ends_at' => now()->addDays(60)->addHour(8),
            'location' => 'Bola Tangga',
            'registration_url' => null,
        ]);
    }
}