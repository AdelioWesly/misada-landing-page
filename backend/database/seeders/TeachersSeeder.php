<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeachersSeeder extends Seeder
{
    public function run(): void
    {
        Teacher::create([
            'name' => 'Ustadz Ahmad Dani, M.Pd',
            'role' => 'Kepala Madrasah',
            'biography' => 'Kepala madrasah dengan pengalaman 15 tahun dalam pengelolaan pendidikan Islam.',
            'photo_path' => '/images/teachers/ustadz-ahmad.jpg',
            'photo_alt' => 'Ustadz Ahmad Dani',
            'display_order' => 1,
            'status' => 'published',
        ]);

        Teacher::create([
            'name' => 'Ustadah Siti Rohmah, M.Pd',
            'role' => 'Waka Pelaksana',
            'biography' => 'Waka pelaksana bidang pengajaran dengan latar belakang PGSD.',
            'photo_path' => '/images/teachers/ustadah-siti.jpg',
            'photo_alt' => 'Ustadah Siti Rohmah',
            'display_order' => 2,
            'status' => 'published',
        ]);

        Teacher::create([
            'name' => 'Pak Bambang Setiawan, S.Pd',
            'role' => 'Guru PKN',
            'biography' => 'Guru PKN dengan metode pembelajaran interaktif dan modern.',
            'photo_path' => '/images/teachers/pak-bambang.jpg',
            'photo_alt' => 'Pak Bambang Setiawan',
            'display_order' => 3,
            'status' => 'published',
        ]);

        Teacher::create([
            'name' => 'Ibu Dewi Anggraini, S.Pd',
            'role' => 'Guru Bahasa Indonesia',
            'biography' => 'Guru Bahasa Indonesia dengan pendekatanliterasi dan membaca.',
            'photo_path' => '/images/teachers/ibu-dewi.jpg',
            'photo_alt' => 'Ibu Dewi Anggraini',
            'display_order' => 4,
            'status' => 'published',
        ]);
    }
}