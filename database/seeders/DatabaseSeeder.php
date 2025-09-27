<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting database seeding...');

        // Create admin user if doesn't exist
        $this->command->info('👤 Ensuring admin user exists...');
        User::firstOrCreate(
            ['email' => 'admin@portfolify.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@portfolify.com',
            ]
        );

        // Seed all data in correct order
        $this->call([
            ConfigSeeder::class,      // Configuration settings first
            CategorySeeder::class,    // Categories before posts
            PortfolioSeeder::class,   // Portfolio items
            PostSeeder::class,        // Blog posts (requires categories and users)
            CommentSeeder::class,     // Comments (requires posts)
        ]);

        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->info('');
        $this->command->info('🎉 You can now login with:');
        $this->command->info('   Email: admin@portfolify.com');
        $this->command->info('   Password: password');
    }
}
