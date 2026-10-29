<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Announcement;

class AnnouncementsSeeder extends Seeder
{
    public function run(): void
    {
        Announcement::create([
            'title' => 'Pendaftaran PPDB',
            'slug' => 'pendaftarank-ppdb',
            'summary' => 'Pendaftaran peserta didik baru',
            'body' => 'Pendaftaran peserta didik baru untuk tahun akademik 2024/2025 sudah dibuka. Silakan kunjungi website untuk detail.',
            'status' => 'published',
            'published_at' => now()->subDays(10),
            'expires_at' => now()->addDays(30),
        ]);

        Announcement::create([
            'title' => 'Jadwal Ujian Akhir',
            'slug' => 'jadwal-ujian-akhir',
            'summary' => 'Jadwal ujian akhir semester',
            'body' => 'Ujian akhir semester 1 akan dilaksanakan pada tanggal 20-22 Desember 2024.',
            'status' => 'published',
            'published_at' => now()->subDays(25),
            'expires_at' => now()->addDays(60),
        ]);

        Announcement::create([
            'title' => 'Jadwal Temu Orang Tua',
            'slug' => 'jadwal-temu-ortu',
            'summary' => 'Rapat orang tua kelas',
            'body' => 'Rapat orang tua akan dilaksanakan pada 15 November 2024 pukul 17:00 di depan Gereja.',
            'status' => 'published',
            'published_at' => now()->subDays(18),
            'expires_at' => now()->addDays(45),
        ]);
    }
}