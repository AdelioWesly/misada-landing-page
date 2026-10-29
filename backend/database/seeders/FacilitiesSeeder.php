<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitiesSeeder extends Seeder
{
    public function run(): void
    {
        Facility::create([
            'name' => 'Laboratorium Informatika',
            'slug' => 'laboratorium-informatika',
            'description' => 'Lab komputer lengkap untuk pembelajaran teknologi',
            'image_path' => '/images/facilities/computer-lab.jpg',
            'alt_text' => 'Laboratorium Informatika',
            'display_order' => 1,
            'status' => 'published',
        ]);

        Facility::create([
            'name' => 'Perpustakaan',
            'slug' => 'perpustakaan',
            'description' => 'Perpustakaan dengan koleksi buku lengkap',
            'image_path' => '/images/facilities/library.jpg',
            'alt_text' => 'Perpustakaan Madrasah',
            'display_order' => 2,
            'status' => 'published',
        ]);

        Facility::create([
            'name' => 'Gedung Aula',
            'slug' => 'gedung-aula',
            'description' => 'Aula utama untuk acara sekolah',
            'image_path' => '/images/facilities/aula.jpg',
            'alt_text' => 'Gedung Aula',
            'display_order' => 3,
            'status' => 'published',
        ]);

        Facility::create([
            'name' => 'Lapangan Olahraga',
            'slug' => 'lapangan-olahraga',
            'description' => 'Lapangan basket dan voli',
            'image_path' => '/images/facilities/sports-field.jpg',
            'alt_text' => 'Lapangan Olahraga',
            'display_order' => 4,
            'status' => 'published',
        ]);
    }
}