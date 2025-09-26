<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share settings with all views
        View::composer('*', function ($view) {
            $view->with([
                'globalSettings' => $this->getGlobalSettings(),
                'seoSettings' => $this->getSeoSettings(),
                'blogSettings' => $this->getBlogSettings(),
            ]);
        });
    }

    /**
     * Get global/general settings
     */
    private function getGlobalSettings(): array
    {
        return [
            'site_name' => db_config('general.site_name', config('app.name')),
            'site_description' => db_config('general.site_description', 'Professional portfolio website'),
            'contact_email' => db_config('general.contact_email', 'hello@example.com'),
            'primary_color' => db_config('general.primary_color', '#3B82F6'),
            'secondary_color' => db_config('general.secondary_color', '#8B5CF6'),
            'dark_mode_enabled' => (bool) db_config('general.dark_mode_enabled', true),
            'default_theme' => db_config('general.default_theme', 'system'),
            'contact_phone' => db_config('general.contact_phone', ''),
            'contact_address' => db_config('general.contact_address', ''),
            'social_twitter' => db_config('general.social_twitter', ''),
            'social_linkedin' => db_config('general.social_linkedin', ''),
            'social_github' => db_config('general.social_github', ''),
            'social_instagram' => db_config('general.social_instagram', ''),
        ];
    }

    /**
     * Get SEO settings
     */
    private function getSeoSettings(): array
    {
        return [
            'default_meta_title' => db_config('seo.default_meta_title', config('app.name')),
            'default_meta_description' => db_config('seo.default_meta_description', ''),
            'default_meta_keywords' => db_config('seo.default_meta_keywords', []),
            'enable_open_graph' => (bool) db_config('seo.enable_open_graph', true),
            'enable_twitter_cards' => (bool) db_config('seo.enable_twitter_cards', true),
            'enable_schema_markup' => (bool) db_config('seo.enable_schema_markup', true),
            'og_image' => db_config('seo.og_image', ''),
            'twitter_handle' => db_config('seo.twitter_handle', ''),
            'google_site_verification' => db_config('seo.google_site_verification', ''),
            'bing_site_verification' => db_config('seo.bing_site_verification', ''),
            'google_analytics_id' => db_config('seo.google_analytics_id', ''),
            'custom_head_code' => db_config('seo.custom_head_code', ''),
            'custom_body_code' => db_config('seo.custom_body_code', ''),
        ];
    }

    /**
     * Get blog settings
     */
    private function getBlogSettings(): array
    {
        return [
            'posts_per_page' => (int) db_config('blog.posts_per_page', 10),
            'allow_comments' => (bool) db_config('blog.allow_comments', true),
            'moderate_comments' => (bool) db_config('blog.moderate_comments', true),
            'notify_on_comment' => (bool) db_config('blog.notify_on_comment', true),
            'comment_system' => db_config('blog.comment_system', 'built-in'),
            'show_author_bio' => (bool) db_config('blog.show_author_bio', true),
            'show_related_posts' => (bool) db_config('blog.show_related_posts', true),
            'related_posts_count' => (int) db_config('blog.related_posts_count', 3),
            'enable_tags' => (bool) db_config('blog.enable_tags', true),
            'enable_reading_time' => (bool) db_config('blog.enable_reading_time', true),
            'date_format' => db_config('blog.date_format', 'M j, Y'),
            'featured_posts_count' => (int) db_config('blog.featured_posts_count', 3),
            'show_featured_on_homepage' => (bool) db_config('blog.show_featured_on_homepage', true),
        ];
    }
}