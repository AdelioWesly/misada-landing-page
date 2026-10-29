<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GalleriesSeeder extends Seeder
{
    public function run(): void
    {
        Gallery::create([
            'title' => 'Galeri Acara 2024',
            'slug' => 'galeri-acara-2024',
            'summary' => 'Foto-foto kegiatan tahun 2024',
            'body' => 'Foto-foto kegiatan tahun 2024 madrasah mencakup berbagai acara sekolah',
            'status' => 'published',
            'published_at' => now()->subDays(20),
        ]);

        Gallery::create([
            'title' => 'Fakultas Unggul',
            'slug' => 'fakultas-unggul',
            'summary' => 'Foto dokumentasi fasilitas unggul',
            'body' => 'Foto dokumentasi fasilitas unggul madrasah',
            'status' => 'published',
            'published_at' => now()->subDays(40),
        ]);

        Gallery::create([
            'title' => 'Galeri D Prasarana',
            'slug' => 'galeri-d-prasarana',
            'summary' => 'Foto dokumentasi sarana prasarana',
            'body' => 'Foto dokumentasi sarana prasarana madrasah',
            'status' => 'published',
            'published_at' => now()->subDays(50),
        ]);
    }
}