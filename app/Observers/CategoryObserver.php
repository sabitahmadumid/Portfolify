<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        $this->clearSeoCache();
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        $this->clearSeoCache();
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        $this->clearSeoCache();
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        $this->clearSeoCache();
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        $this->clearSeoCache();
    }

    /**
     * Clear sitemap and RSS cache when categories change.
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
