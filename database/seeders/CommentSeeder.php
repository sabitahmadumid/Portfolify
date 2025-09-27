<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::where('allow_comments', true)->get();

        if ($posts->isEmpty()) {
            $this->command->warn('No posts found that allow comments. Make sure to run PostSeeder first.');

            return;
        }

        // Create comments for posts
        foreach ($posts as $post) {
            // Create 1-5 comments per post randomly
            $commentCount = rand(1, 5);
            Comment::factory()
                ->count($commentCount)
                ->for($post)
                ->create();
        }

        $this->command->info('Comments seeded successfully!');
    }
}
