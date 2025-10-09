<?php

namespace App\Observers;

use App\Models\Portfolio;
use Illuminate\Support\Facades\Cache;

class PortfolioObserver
{
    /**
     * Handle the Portfolio "created" event.
     */
    public function created(Portfolio $portfolio): void
    {
        $this->clearSitemapCache();
    }

    /**
     * Handle the Portfolio "updated" event.
     */
    public function updated(Portfolio $portfolio): void
    {
        $this->clearSitemapCache();
    }

    /**
     * Handle the Portfolio "deleted" event.
     */
    public function deleted(Portfolio $portfolio): void
    {
        $this->clearSitemapCache();
    }

    /**
     * Handle the Portfolio "restored" event.
     */
    public function restored(Portfolio $portfolio): void
    {
        $this->clearSitemapCache();
    }

    /**
     * Handle the Portfolio "force deleted" event.
     */
    public function forceDeleted(Portfolio $portfolio): void
    {
        $this->clearSitemapCache();
    }

    /**
     * Clear sitemap cache when portfolio items change.
     */
    protected function clearSitemapCache(): void
    {
        if (config('blog.sitemap.enabled')) {
            Cache::forget('sitemap');
        }
    }
}
