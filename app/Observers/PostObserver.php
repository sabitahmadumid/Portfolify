<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        $this->clearSeoCache();
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        $this->clearSeoCache();
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        $this->clearSeoCache();
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        $this->clearSeoCache();
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        $this->clearSeoCache();
    }

    /**
     * Clear sitemap and RSS feed cache when posts change.
     */
    protected function clearSeoCache(): void
    {
        if (config('blog.sitemap.enabled')) {
            Cache::forget('sitemap');
        }

        if (config('blog.rss.enabled')) {
            Cache::forget('rss_feed');
        }
    }
}
