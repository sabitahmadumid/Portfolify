<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactMessage>
 */
class ContactMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'subject' => $this->faker->randomElement(['project', 'collaboration', 'consultation', 'support', 'other']),
            'budget' => $this->faker->randomElement(['under-5k', '5k-10k', '10k-25k', '25k-50k', '50k-plus', 'discuss']),
            'message' => $this->faker->paragraph(3),
            'status' => $this->faker->randomElement(['unread', 'read']),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'read_at' => $this->faker->optional(0.3)->dateTimeBetween('-1 week', 'now'),
        ];
    }
}
