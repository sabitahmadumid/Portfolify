<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Blog Configuration
    |--------------------------------------------------------------------------
    |
    | Performance-optimized blog configuration
    |
    */

    'enabled' => env('BLOG_ENABLED', true),

    'posts_per_page' => env('BLOG_POSTS_PER_PAGE', 12),

    'featured_posts_count' => env('BLOG_FEATURED_POSTS_COUNT', 3),

    'related_posts_count' => env('BLOG_RELATED_POSTS_COUNT', 3),

    'allow_comments' => env('BLOG_ALLOW_COMMENTS', true),

    'moderate_comments' => env('BLOG_MODERATE_COMMENTS', true),

    'notify_on_comment' => env('BLOG_NOTIFY_ON_COMMENT', true),

    'show_author_bio' => env('BLOG_SHOW_AUTHOR_BIO', true),

    'show_related_posts' => env('BLOG_SHOW_RELATED_POSTS', true),

    'enable_tags' => env('BLOG_ENABLE_TAGS', true),

    'enable_reading_time' => env('BLOG_ENABLE_READING_TIME', true),

    'date_format' => env('BLOG_DATE_FORMAT', 'M j, Y'),

    /*
    |--------------------------------------------------------------------------
    | Performance Settings
    |--------------------------------------------------------------------------
    */

    'cache' => [
        'posts_ttl' => env('BLOG_CACHE_POSTS_TTL', 300), // 5 minutes
        'categories_ttl' => env('BLOG_CACHE_CATEGORIES_TTL', 3600), // 1 hour
        'featured_posts_ttl' => env('BLOG_CACHE_FEATURED_TTL', 600), // 10 minutes
        'comments_ttl' => env('BLOG_CACHE_COMMENTS_TTL', 600), // 10 minutes
    ],

    'search' => [
        'min_length' => env('BLOG_SEARCH_MIN_LENGTH', 3),
        'use_fulltext' => env('BLOG_SEARCH_USE_FULLTEXT', true),
    ],

    'sitemap' => [
        'enabled' => env('BLOG_SITEMAP_ENABLED', true),
        'cache_ttl' => env('BLOG_SITEMAP_CACHE_TTL', 86400), // 24 hours
        'include_images' => env('BLOG_SITEMAP_INCLUDE_IMAGES', true),
    ],

    'rss' => [
        'enabled' => env('BLOG_RSS_ENABLED', true),
        'posts_count' => env('BLOG_RSS_POSTS_COUNT', 20),
        'cache_ttl' => env('BLOG_RSS_CACHE_TTL', 3600), // 1 hour
        'include_content' => env('BLOG_RSS_INCLUDE_CONTENT', true),
    ],
];
