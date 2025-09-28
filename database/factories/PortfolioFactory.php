<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio>
 */
class PortfolioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $technologies = [
            ['Laravel', 'PHP', 'MySQL'],
            ['React', 'TypeScript', 'Node.js'],
            ['Vue.js', 'Tailwind CSS', 'Laravel'],
            ['Next.js', 'PostgreSQL', 'Prisma'],
            ['WordPress', 'PHP', 'MySQL'],
            ['Figma', 'Adobe XD', 'Sketch'],
        ];

        return [
            'title' => \fake()->words(3, true),
            'description' => \fake()->sentences(2, true),
            'content' => \fake()->paragraphs(5, true),
            'client' => \fake()->optional()->company(),
            'project_url' => \fake()->optional()->url(),
            'github_url' => \fake()->optional()->url(),
            'technologies' => \fake()->randomElement($technologies),
            'project_date' => \fake()->dateTimeBetween('-2 years'),
            'is_featured' => false,
            'is_published' => true,
            'meta_title' => \fake()->optional()->words(5, true),
            'meta_description' => \fake()->optional()->sentence(),
            'meta_keywords' => \fake()->optional()->words(5),
            'sort_order' => \fake()->numberBetween(0, 100),
        ];
    }

    /**
     * Indicate that the portfolio item is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'sort_order' => \fake()->numberBetween(1, 10),
        ]);
    }

    /**
     * Indicate that the portfolio item is unpublished.
     */
    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }
}
