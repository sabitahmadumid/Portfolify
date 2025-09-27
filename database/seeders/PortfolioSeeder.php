<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create featured portfolio items
        Portfolio::factory()->count(3)->featured()->create();

        // Create regular portfolio items
        Portfolio::factory()->count(8)->create();

        $this->command->info('Portfolio items seeded successfully!');
    }
}
