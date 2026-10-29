<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\NewsCategory;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $categories = NewsCategory::all();

        News::create([
            'title' => 'Majulah Baru dengan Karakter',
            'slug' => 'majelah-baru-dengan-karakter',
            'summary' => 'Selamat datang tahun akademik baru',
            'body' => 'Madrasah MISADA membuka tahun akademik 2024/2025 dengan nuung berkesan dan semangat baru.',
            'status' => 'published',
            'published_at' => now()->subDays(5),
            'category_id' => $categories->random()?->id,
            'author_id' => 1,
        ]);

        News::create([
            'title' => 'Lomba Menulis Nasional',
            'slug' => 'lomba-tulis-nasional',
            'summary' => 'Siswa MISADA juara lomba menulis nasional',
            'body' => 'Beberapa siswa madrasah berhasil meraih juara dalam lomba menulis nasional tingkat sekolah menengah.',
            'status' => 'published',
            'published_at' => now()->subDays(15),
            'category_id' => $categories->random()?->id,
            'author_id' => 1,
        ]);

        News::create([
            'title' => 'Biodata Olahraga 2024',
            'slug' => 'biodata-olahraga-2024',
            'summary' => 'Ekstrakurikuler olahraga menjadi juara',
            'body' => 'Tim eksekutif olahraga madrasah menggelar lomba intra-sekolah dengan peserta dari seluruh kelas.',
            'status' => 'published',
            'published_at' => now()->subDays(20),
            'category_id' => $categories->random()?->id,
            'author_id' => 1,
        ]);

        News::create([
            'title' => 'Pendidikan Karakter Baru',
            'slug' => 'pendidikan-karakter-baru',
            'summary' => 'Implementasi pendidikan karakter terintegrasi',
            'body' => 'Madrasah MISADA meluncurkan program pendidikan karakter terintegrasi dalam kurikulum belajar sehari-hari.',
            'status' => 'published',
            'published_at' => now()->subDays(30),
            'category_id' => $categories->random()?->id,
            'author_id' => 1,
        ]);
    }
}