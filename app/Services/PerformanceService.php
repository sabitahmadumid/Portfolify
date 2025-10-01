<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PerformanceService
{
    /**
     * Warm up critical caches
     */
    public function warmCache(): void
    {
        $this->warmBlogCache();
        $this->warmCategoryCache();
        $this->warmSettingsCache();
    }

    /**
     * Clear all application caches
     */
    public function clearAllCaches(): void
    {
        Cache::flush();

        // Clear specific cache patterns
        $this->clearPatternCache('post_*');
        $this->clearPatternCache('category_*');
        $this->clearPatternCache('blog.*');
        $this->clearPatternCache('settings.*');
    }

    /**
     * Warm up blog-related caches
     */
    private function warmBlogCache(): void
    {
        // Cache featured posts
        Cache::remember('blog.featured_posts', 600, function () {
            return Post::published()
                ->featured()
                ->with(['category:id,name,slug'])
                ->select(['id', 'title', 'slug', 'excerpt', 'category_id', 'featured_image_id', 'published_at'])
                ->latest('published_at')
                ->take(config('blog.featured_posts_count', 3))
                ->get();
        });

        // Cache recent posts for homepage
        Cache::remember('homepage.recent_posts', 900, function () {
            return Post::published()
                ->with(['category:id,name,slug'])
                ->select(['id', 'title', 'slug', 'excerpt', 'category_id', 'featured_image_id', 'published_at'])
                ->latest('published_at')
                ->take(3)
                ->get();
        });

        // Cache popular posts
        Cache::remember('blog.popular_posts', 1800, function () {
            return Post::published()
                ->popular(30)
                ->with(['category:id,name,slug'])
                ->select(['id', 'title', 'slug', 'excerpt', 'category_id', 'featured_image_id', 'published_at', 'views_count'])
                ->take(5)
                ->get();
        });
    }

    /**
     * Warm up category caches
     */
    private function warmCategoryCache(): void
    {
        Cache::remember('blog.categories', 3600, function () {
            return Category::active()
                ->withCount('publishedPosts')
                ->orderBy('sort_order')
                ->get(['id', 'name', 'slug', 'color']);
        });

        // Cache individual category post counts
        Category::active()->get()->each(function ($category) {
            Cache::remember("category_{$category->id}_posts_count", 1800, function () use ($category) {
                return $category->publishedPosts()->count();
            });
        });
    }

    /**
     * Warm up settings caches
     */
    private function warmSettingsCache(): void
    {
        // Warm settings by accessing them (which triggers the cache)
        config('app.name'); // This triggers global settings caching

        // Warm specific setting groups if they exist
        try {
            \Inerba\DbConfig\DbConfig::get('blog.enabled', true);
            \Inerba\DbConfig\DbConfig::get('seo.meta_title', '');
        } catch (\Exception $e) {
            // Settings might not be configured yet, ignore
        }
    }

    /**
     * Clear cache by pattern (implementation depends on cache driver)
     */
    private function clearPatternCache(string $pattern): void
    {
        // This is a simplified implementation
        // For Redis, you could use SCAN with patterns
        // For file cache, you could scan directory

        if (config('cache.default') === 'redis') {
            $redis = Cache::getRedis();
            $keys = $redis->keys(config('cache.prefix', 'laravel_cache:').$pattern);
            if (! empty($keys)) {
                $redis->del($keys);
            }
        }
    }

    /**
     * Get cache statistics
     */
    public function getCacheStats(): array
    {
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::published()->count(),
            'total_categories' => Category::count(),
            'active_categories' => Category::active()->count(),
            'total_comments' => Comment::count(),
            'approved_comments' => Comment::approved()->count(),
        ];

        // Add cache hit rates if available
        if (config('cache.default') === 'redis') {
            $redis = Cache::getRedis();
            $info = $redis->info('stats');
            $stats['cache_hit_rate'] = $info['keyspace_hits'] / ($info['keyspace_hits'] + $info['keyspace_misses']) * 100;
        }

        return $stats;
    }

    /**
     * Optimize database
     */
    public function optimizeDatabase(): void
    {
        // Analyze tables for better query performance
        $tables = ['posts', 'categories', 'comments', 'users', 'curator'];

        foreach ($tables as $table) {
            DB::statement("ANALYZE TABLE {$table}");
        }

        // Clean up old data
        $this->cleanupOldData();
    }

    /**
     * Clean up old data
     */
    private function cleanupOldData(): void
    {
        // Delete old failed jobs (older than 1 week)
        DB::table('failed_jobs')
            ->where('failed_at', '<', now()->subWeek())
            ->delete();

        // Delete old cache entries if using database cache
        if (config('cache.default') === 'database') {
            DB::table(config('cache.stores.database.table', 'cache'))
                ->where('expiration', '<', now()->timestamp)
                ->delete();
        }

        // Delete old sessions (older than 1 month)
        DB::table('sessions')
            ->where('last_activity', '<', now()->subMonth()->timestamp)
            ->delete();
    }

    /**
     * Flush pending view counts
     */
    public function flushViewCounts(): void
    {
        // Get all cached view counts and flush them to database
        if (config('cache.default') === 'redis') {
            $redis = Cache::getRedis();
            $keys = $redis->keys(config('cache.prefix', 'laravel_cache:').'post_views_*');

            foreach ($keys as $key) {
                $postId = str_replace([config('cache.prefix', 'laravel_cache:'), 'post_views_'], '', $key);
                $views = $redis->get($key);

                if ($views > 0) {
                    Post::where('id', $postId)->increment('views_count', $views);
                    $redis->del($key);
                }
            }
        }
    }
}
