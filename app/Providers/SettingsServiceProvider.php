<?php

namespace App\Providers;

use Awcodes\Curator\Models\Media;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share cached settings with all views
        View::composer('*', function ($view) {
            $view->with([
                'globalSettings' => cache()->remember('settings.global', 3600, fn () => $this->getGlobalSettings()),
                'seoSettings' => cache()->remember('settings.seo', 3600, fn () => $this->getSeoSettings()),
                'blogSettings' => cache()->remember('settings.blog', 3600, fn () => $this->getBlogSettings()),
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
            'site_tagline' => db_config('general.site_tagline', ''),
            'primary_color' => db_config('general.primary_color', '#3B82F6'),
            'secondary_color' => db_config('general.secondary_color', '#8B5CF6'),
            'contact_email' => db_config('general.contact_email', 'hello@example.com'),
            'contact_phone' => db_config('general.contact_phone', ''),
            'contact_address' => db_config('general.contact_address', ''),
            'social_twitter' => db_config('general.social_twitter', ''),
            'social_linkedin' => db_config('general.social_linkedin', ''),
            'social_github' => db_config('general.social_github', ''),
            'social_instagram' => db_config('general.social_instagram', ''),
            'social_facebook' => db_config('general.social_facebook', ''),
            'social_youtube' => db_config('general.social_youtube', ''),
            'site_logo' => $this->getMedia(db_config('general.site_logo')),
            'site_logo_dark' => $this->getMedia(db_config('general.site_logo_dark')),
            'site_favicon' => $this->getMedia(db_config('general.site_favicon')),
            'profile_image' => $this->getMedia(db_config('general.profile_image')),
            'site_logo_url' => $this->getMediaUrl(db_config('general.site_logo')),
            'site_logo_dark_url' => $this->getMediaUrl(db_config('general.site_logo_dark')),
            'site_favicon_url' => $this->getMediaUrl(db_config('general.site_favicon')),
            'profile_image_url' => $this->getMediaUrl(db_config('general.profile_image')),
        ];
    }

    /**
     * Get SEO settings
     */
    private function getSeoSettings(): array
    {
        return [
            'meta_title' => db_config('seo.meta_title', config('app.name')),
            'meta_description' => db_config('seo.meta_description', ''),
            'meta_keywords' => db_config('seo.meta_keywords', []),
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
            'enabled' => (bool) db_config('blog.enabled', true),
            'posts_per_page' => (int) db_config('blog.posts_per_page', 10),
            'show_featured_posts' => (bool) db_config('blog.show_featured_posts', true),
            'featured_posts_count' => (int) db_config('blog.featured_posts_count', 3),
            'allow_comments' => (bool) db_config('blog.allow_comments', true),
            'moderate_comments' => (bool) db_config('blog.moderate_comments', true),
            'notify_on_comment' => (bool) db_config('blog.notify_on_comment', true),
            'show_author_bio' => (bool) db_config('blog.show_author_bio', true),
            'show_related_posts' => (bool) db_config('blog.show_related_posts', true),
            'related_posts_count' => (int) db_config('blog.related_posts_count', 3),
            'enable_tags' => (bool) db_config('blog.enable_tags', true),
            'enable_reading_time' => (bool) db_config('blog.enable_reading_time', true),
            'date_format' => db_config('blog.date_format', 'M j, Y'),
        ];
    }

    /**
     * Get media object from media ID
     */
    private function getMedia($mediaId): ?Media
    {
        if (! $mediaId) {
            return null;
        }

        return Media::find($mediaId);
    }

    /**
     * Get media URL from media ID
     */
    private function getMediaUrl($mediaId): ?string
    {
        if (! $mediaId) {
            return null;
        }

        $media = Media::find($mediaId);

        return $media ? $media->url : null;
    }
}
