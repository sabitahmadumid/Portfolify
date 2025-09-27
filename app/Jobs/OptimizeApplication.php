<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class OptimizeApplication implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private array $options = []
    ) {
        $this->options = array_merge([
            'cache' => true,
            'views' => true,
            'routes' => true,
            'config' => true,
            'assets' => false,
        ], $options);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Starting application optimization job');

        try {
            // Clear old optimizations first
            $this->clearOptimizations();

            // Run optimizations
            if ($this->options['config']) {
                $this->optimizeConfig();
            }

            if ($this->options['routes']) {
                $this->optimizeRoutes();
            }

            if ($this->options['views']) {
                $this->optimizeViews();
            }

            if ($this->options['cache']) {
                $this->optimizeCache();
            }

            if ($this->options['assets']) {
                $this->optimizeAssets();
            }

            // Run performance optimization
            $this->runPerformanceOptimization();

            Log::info('Application optimization job completed successfully');

        } catch (\Exception $e) {
            Log::error('Application optimization job failed: '.$e->getMessage());
            throw $e;
        }
    }

    private function clearOptimizations(): void
    {
        Log::info('Clearing existing optimizations');

        Artisan::call('optimize:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
    }

    private function optimizeConfig(): void
    {
        Log::info('Optimizing configuration');
        Artisan::call('config:cache');
    }

    private function optimizeRoutes(): void
    {
        Log::info('Optimizing routes');
        Artisan::call('route:cache');
    }

    private function optimizeViews(): void
    {
        Log::info('Optimizing views');
        Artisan::call('view:cache');
    }

    private function optimizeCache(): void
    {
        Log::info('Running cache optimization');
        Artisan::call('cache:warm');
    }

    private function optimizeAssets(): void
    {
        Log::info('Optimizing assets');
        Artisan::call('optimize:assets');
    }

    private function runPerformanceOptimization(): void
    {
        Log::info('Running performance optimization');
        Artisan::call('optimize:performance');
    }
}
