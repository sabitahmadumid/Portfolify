<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class SeoService
{
    /**
     * Clear all SEO-related caches.
     */
    public static function clearCache(): void
    {
        if (config('blog.sitemap.enabled')) {
            Cache::forget('sitemap');
        }

        if (config('blog.rss.enabled')) {
            Cache::forget('rss_feed');
        }
    }

    /**
     * Get sitemap URL.
     */
    public static function getSitemapUrl(): string
    {
        return route('sitemap');
    }

    /**
     * Get RSS feed URL.
     */
    public static function getRssUrl(): string
    {
        return route('rss');
    }

    /**
     * Check if sitemap is enabled.
     */
    public static function isSitemapEnabled(): bool
    {
        return (bool) config('blog.sitemap.enabled');
    }

    /**
     * Check if RSS is enabled.
     */
    public static function isRssEnabled(): bool
    {
        return (bool) config('blog.rss.enabled');
    }

    /**
     * Get RSS meta tags for HTML head.
     */
    public static function getRssMetaTags(): array
    {
        if (! self::isRssEnabled()) {
            return [];
        }

        return [
            'rss' => [
                'rel' => 'alternate',
                'type' => 'application/rss+xml',
                'title' => config('app.name').' - RSS Feed',
                'href' => self::getRssUrl(),
            ],
            'feed' => [
                'rel' => 'alternate',
                'type' => 'application/rss+xml',
                'title' => config('app.name').' - Blog Feed',
                'href' => route('feed'),
            ],
        ];
    }
}
