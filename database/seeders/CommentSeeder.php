<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Root comment on Material 1
        $comment1 = Comment::create([
            'user_id' => 3, // Jane Smith
            'material_id' => 1,
            'parent_id' => null,
            'body' => 'Penjelasan yang sangat bagus tentang Laravel! Saya baru belajar dan ini sangat membantu.',
        ]);

        // Reply to comment 1
        Comment::create([
            'user_id' => 2, // John Doe (author)
            'material_id' => 1,
            'parent_id' => $comment1->id,
            'body' => 'Terima kasih! Semoga bermanfaat untuk pembelajaran Laravel Anda.',
        ]);

        // Another reply to comment 1
        Comment::create([
            'user_id' => 4, // Bob Wilson
            'material_id' => 1,
            'parent_id' => $comment1->id,
            'body' => 'Saya juga baru belajar Laravel. Ada rekomendasi project untuk praktik?',
        ]);

        // Root comment on Material 3 (React)
        $comment2 = Comment::create([
            'user_id' => 2, // John Doe
            'material_id' => 3,
            'parent_id' => null,
            'body' => 'Hooks memang game changer di React. Lebih clean daripada class components.',
        ]);

        // Reply to comment 2
        Comment::create([
            'user_id' => 3, // Jane Smith (author)
            'material_id' => 3,
            'parent_id' => $comment2->id,
            'body' => 'Betul! Dan lebih mudah untuk testing juga. Functional components dengan hooks lebih predictable.',
        ]);

        // Another root comment on Material 5 (Database)
        Comment::create([
            'user_id' => 1, // Admin
            'material_id' => 5,
            'parent_id' => null,
            'body' => 'Normalisasi database memang penting untuk menghindari data anomalies. Good explanation!',
        ]);
    }
} 