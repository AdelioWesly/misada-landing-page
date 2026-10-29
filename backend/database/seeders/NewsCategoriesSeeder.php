<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NewsCategory;

class NewsCategoriesSeeder extends Seeder
{
    public function run(): void
    {
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
            'name' => 'Academik',
            'slug' => 'akademik',
            'description' => 'Berita akademik dan hasil belajar',
        ]);
    }
}