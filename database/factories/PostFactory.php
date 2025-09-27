<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $publishedAt = $this->faker->boolean(80) ? $this->faker->dateTimeBetween('-1 year') : null;

        return [
            'title' => $this->faker->sentence(6),
            'excerpt' => $this->faker->paragraph(2),
            'content' => $this->faker->paragraphs(8, true),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'is_published' => ! is_null($publishedAt),
            'is_featured' => false,
            'published_at' => $publishedAt,
            'allow_comments' => $this->faker->boolean(90),
            'meta_title' => $this->faker->optional()->sentence(4),
            'meta_description' => $this->faker->optional()->paragraph(),
            'meta_keywords' => $this->faker->optional()->words(5),
            'tags' => $this->faker->optional()->words(3),
            'reading_time' => $this->faker->numberBetween(2, 15),
            'views_count' => $this->faker->numberBetween(0, 1000),
        ];
    }

    /**
     * Indicate that the post is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'is_published' => true,
            'published_at' => $this->faker->dateTimeBetween('-6 months'),
        ]);
    }

    /**
     * Indicate that the post is unpublished.
     */
    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
            'published_at' => null,
        ]);
    }

    /**
     * Indicate that the post is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
            'published_at' => $this->faker->dateTimeBetween('-1 year'),
        ]);
    }
}
