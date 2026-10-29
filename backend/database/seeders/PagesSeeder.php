<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;

class PagesSeeder extends Seeder
{
    public function run(): void
    {
        Page::create([
            'title' => 'Visi dan Misi',
            'slug' => 'visi-misi',
            'summary' => 'Visi dan misi sekolah',
            'body' => 'Visi: Menjadi madrasah hebat martabat. Misi: Meningkatkan kualitas pendidikan melalui pembelajaran yang inspiratif.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Page::create([
            'title' => 'Sejarah',
            'slug' => 'sejarah',
            'summary' => 'Sejarah sekolah',
            'body' => 'Madrasah MISADA berdiri tahun 2015 dan telah berkembang pesat sejak entonces.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Page::create([
            'title' => 'Staf Guru dan Karyawan',
            'slug' => 'staf-guru',
            'summary' => 'Informasi staf guru dan karyawan',
            'body' => 'Daftar lengkap staf pengajar dan tenaga kaderya.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Page::create([
            'title' => 'Fasilitas dan Sarana Prasarana',
            'slug' => 'fasilitas-sarana',
            'summary' => 'Informasi fasilitas dan sarana prasarana',
            'body' => 'Lengkap fasilitas pembelajaran dan saranaukung proses pendidikan.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Page::create([
            'title' => 'Galeri',
            'slug' => 'galeri',
            'summary' => 'Galeri sekolah',
            'body' => 'Galeri fotografi kegiatan dan acara sekolah.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Page::create([
            'title' => 'Berita',
            'slug' => 'berita',
            'summary' => 'Informasi berita terbaru',
            'body' => 'Berita terbaru dari madrasah.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Page::create([
            'title' => 'Pengumuman',
            'slug' => 'pengumuman',
            'summary' => 'Pengumuman terbaru',
            'body' => 'Pengumuman penting untuk siswa dan orang tua.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Page::create([
            'title' => 'Agenda',
            'slug' => 'agenda',
            'summary' => 'Agenda sekolah',
            'body' => 'Jadwal acara dan kegiatan sekolah.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Page::create([
            'title' => 'Alumni',
            'slug' => 'alumni',
            'summary' => 'Data alumni madrasah',
            'body' => 'Informasi data separau lulusan madrasah.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Page::create([
            'title' => 'E-Learning',
            'slug' => 'e-learning',
            'summary' => 'Informasi sistem e-learning',
            'body' => 'Sistem pembelajaran daring dan sumber daya.',
            'status' => 'published',
            'published_at' => now(),
        ]);
    }
}