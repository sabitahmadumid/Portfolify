<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Articles about web development, frameworks, and best practices.',
                'color' => '#3B82F6',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Design',
                'slug' => 'design',
                'description' => 'UI/UX design principles, tips, and inspiration.',
                'color' => '#8B5CF6',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Latest technology trends and innovations.',
                'color' => '#10B981',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Tutorial',
                'slug' => 'tutorial',
                'description' => 'Step-by-step guides and tutorials.',
                'color' => '#F59E0B',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Opinion',
                'slug' => 'opinion',
                'description' => 'Personal thoughts and industry opinions.',
                'color' => '#EF4444',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        $this->command->info('Categories seeded successfully!');
    }
}
