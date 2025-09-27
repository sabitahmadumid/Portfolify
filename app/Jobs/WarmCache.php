<?php

namespace App\Jobs;

use App\Services\PerformanceService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WarmCache implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private ?string $cacheType = null
    ) {}

    /**
     * Execute the job.
     */
    public function handle(PerformanceService $performanceService): void
    {
        match ($this->cacheType) {
            'blog' => $this->warmBlogCache($performanceService),
            'settings' => $this->warmSettingsCache($performanceService),
            default => $performanceService->warmCache()
        };
    }

    private function warmBlogCache(PerformanceService $performanceService): void
    {
        $performanceService->warmBlogCache();
    }

    private function warmSettingsCache(PerformanceService $performanceService): void
    {
        $performanceService->warmSettingsCache();
    }
}
