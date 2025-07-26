<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
            'judul' => 'Laravel untuk Pemula',
            'deskripsi' => 'Kursus Laravel lengkap untuk pemula. Pelajari dasar-dasar Laravel framework mulai dari instalasi, routing, controller, model, view, hingga database migration dan seeding.',
            'thumbnail' => null,
            'kategori' => 'Web Development',
            'status' => 'approved',
            'user_id' => 2, // John Doe
        ]);

        Course::create([
            'judul' => 'React.js Advanced Concepts',
            'deskripsi' => 'Kursus React.js tingkat lanjut yang membahas hooks, context API, state management dengan Redux, testing, dan optimasi performa aplikasi React.',
            'thumbnail' => null,
            'kategori' => 'Frontend Development',
            'status' => 'approved',
            'user_id' => 3, // Jane Smith
        ]);

        Course::create([
            'judul' => 'Database Design & MySQL',
            'deskripsi' => 'Pelajari cara merancang database yang efisien dan optimal. Termasuk normalisasi, relationship, indexing, query optimization, dan best practices MySQL.',
            'thumbnail' => null,
            'kategori' => 'Database',
            'status' => 'approved',
            'user_id' => 4, // Bob Wilson
        ]);
    }
} 