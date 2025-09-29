<?php

namespace Database\Factories;

use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Portfolio>
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
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->sentences(2, true),
            'content' => $this->faker->paragraphs(5, true),
            'client' => $this->faker->optional()->company(),
            'project_url' => $this->faker->optional()->url(),
            'github_url' => $this->faker->optional()->url(),
            'technologies' => $this->faker->randomElement($technologies),
            'project_date' => $this->faker->dateTimeBetween('-2 years'),
            'is_featured' => false,
            'is_published' => true,
            'meta_title' => $this->faker->optional()->words(5, true),
            'meta_description' => $this->faker->optional()->sentence(),
            'meta_keywords' => $this->faker->optional()->words(5),
            'sort_order' => $this->faker->numberBetween(0, 100),
        ];
    }

    /**
     * Indicate that the portfolio item is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'sort_order' => $this->faker->numberBetween(1, 10),
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
