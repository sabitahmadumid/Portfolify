<?php

namespace App\Console\Commands;

use App\Jobs\OptimizeApplication;
use App\Jobs\WarmCache;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;

class DeployOptimize extends Command
{
    protected $signature = 'deploy:optimize {--queue : Run optimizations in background}';

    protected $description = 'Run all deployment optimizations for production';

    public function handle(): int
    {
        $this->info('Starting deployment optimization...');

        if ($this->option('queue')) {
            return $this->runInBackground();
        }

        return $this->runSynchronously();
    }

    private function runInBackground(): int
    {
        $this->info('Queuing optimization jobs...');

        // Queue the main optimization job
        OptimizeApplication::dispatch([
            'cache' => true,
            'views' => true,
            'routes' => true,
            'config' => true,
            'assets' => true,
        ]);

        // Queue cache warming job
        WarmCache::dispatch();

        $this->info('Optimization jobs queued successfully!');
        $this->line('Monitor with: php artisan queue:work');

        return Command::SUCCESS;
    }

    private function runSynchronously(): int
    {
        // Clear existing optimizations
        $this->info('Clearing existing optimizations...');
        $this->call('optimize:clear');

        // Run Laravel optimizations
        $this->info('Running Laravel optimizations...');
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('view:cache');

        // Run custom optimizations
        $this->info('Running performance optimizations...');
        $this->call('optimize:performance');

        // Warm caches
        $this->info('Warming application caches...');
        $this->call('cache:warm');

        // Build assets
        $this->info('Optimizing assets...');
        $this->call('optimize:assets');

        $this->info('Deployment optimization completed successfully!');

        return Command::SUCCESS;
    }
}
