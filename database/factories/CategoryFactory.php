<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $colors = ['#3B82F6', '#8B5CF6', '#10B981', '#F59E0B', '#EF4444', '#6366F1', '#EC4899'];

        return [
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(),
            'color' => $this->faker->randomElement($colors),
            'is_active' => true,
            'meta_title' => $this->faker->optional()->words(4, true),
            'meta_description' => $this->faker->optional()->sentence(),
        ];
    }

    /**
     * Indicate that the category is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
