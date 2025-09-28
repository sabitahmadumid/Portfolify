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
            'name' => \fake()->name(),
            'email' => \fake()->safeEmail(),
            'subject' => \fake()->randomElement(['project', 'collaboration', 'consultation', 'support', 'other']),
            'budget' => \fake()->randomElement(['under-5k', '5k-10k', '10k-25k', '25k-50k', '50k-plus', 'discuss']),
            'message' => \fake()->paragraph(3),
            'status' => \fake()->randomElement(['unread', 'read']),
            'ip_address' => \fake()->ipv4(),
            'user_agent' => \fake()->userAgent(),
            'read_at' => \fake()->optional(0.3)->dateTimeBetween('-1 week', 'now'),
        ];
    }
}
