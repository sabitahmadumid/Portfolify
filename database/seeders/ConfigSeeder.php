<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configs = [
            // General Settings
            ['key' => 'general.site_name', 'value' => 'Portfolify'],
            ['key' => 'general.site_description', 'value' => 'Professional portfolio website showcasing creative work and insights'],
            ['key' => 'general.contact_email', 'value' => 'hello@portfolify.com'],
            ['key' => 'general.primary_color', 'value' => '#3B82F6'],
            ['key' => 'general.secondary_color', 'value' => '#8B5CF6'],
            ['key' => 'general.dark_mode_enabled', 'value' => '1'],
            ['key' => 'general.default_theme', 'value' => 'system'],
            
            // Blog Settings
            ['key' => 'blog.posts_per_page', 'value' => '10'],
            ['key' => 'blog.allow_comments', 'value' => '1'],
            ['key' => 'blog.moderate_comments', 'value' => '1'],
            ['key' => 'blog.show_author_bio', 'value' => '1'],
            ['key' => 'blog.enable_reading_time', 'value' => '1'],
            ['key' => 'blog.featured_posts_count', 'value' => '3'],
            ['key' => 'blog.show_featured_on_homepage', 'value' => '1'],
            ['key' => 'blog.date_format', 'value' => 'M j, Y'],
            ['key' => 'blog.show_related_posts', 'value' => '1'],
            ['key' => 'blog.related_posts_count', 'value' => '3'],
            ['key' => 'blog.enable_tags', 'value' => '1'],
            ['key' => 'blog.comment_system', 'value' => 'built-in'],
            ['key' => 'blog.notify_on_comment', 'value' => '1'],
            
            // SEO Settings
            ['key' => 'seo.default_meta_title', 'value' => 'Portfolify - Modern Portfolio & Blog'],
            ['key' => 'seo.default_meta_description', 'value' => 'Professional portfolio website showcasing creative work and insights'],
            ['key' => 'seo.enable_schema_markup', 'value' => '1'],
            ['key' => 'seo.enable_open_graph', 'value' => '1'],
            ['key' => 'seo.enable_twitter_cards', 'value' => '1'],
        ];

        foreach ($configs as $config) {
            // Extract group and key from the dot notation
            $parts = explode('.', $config['key']);
            $group = $parts[0] ?? 'general';
            $key = $parts[1] ?? $config['key'];
            
            DB::table('db_config')->updateOrInsert(
                ['group' => $group, 'key' => $key],
                [
                    'group' => $group,
                    'key' => $key,
                    'settings' => json_encode($config['value']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
