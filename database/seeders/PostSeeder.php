<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $categories = Category::all();

        if (! $user || $categories->isEmpty()) {
            $this->command->warn('Users or Categories not found. Make sure to run UserSeeder and CategorySeeder first.');

            return;
        }

        // Create featured blog posts
        Post::factory()
            ->count(3)
            ->featured()
            ->for($user)
            ->recycle($categories)
            ->create();

        // Create regular blog posts
        Post::factory()
            ->count(12)
            ->for($user)
            ->recycle($categories)
            ->create();

        $this->command->info('Blog posts seeded successfully!');
    }
}
