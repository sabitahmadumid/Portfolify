<?php

namespace App\Console\Commands;

use App\Services\PerformanceService;
use Illuminate\Console\Command;

class OptimizePerformance extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'portfolio:optimize {--warm-cache : Warm up application caches} {--clear-cache : Clear all caches} {--database : Optimize database} {--flush-views : Flush pending view counts}';

    /**
     * The console command description.
     */
    protected $description = 'Optimize application performance';

    /**
     * Execute the console command.
     */
    public function handle(PerformanceService $performanceService): int
    {
        $this->info('Starting performance optimization...');

        if ($this->option('clear-cache')) {
            $this->info('Clearing all caches...');
            $performanceService->clearAllCaches();
            $this->info('✓ Caches cleared');
        }

        if ($this->option('warm-cache')) {
            $this->info('Warming up caches...');
            $performanceService->warmCache();
            $this->info('✓ Caches warmed');
        }

        if ($this->option('database')) {
            $this->info('Optimizing database...');
            $performanceService->optimizeDatabase();
            $this->info('✓ Database optimized');
        }

        if ($this->option('flush-views')) {
            $this->info('Flushing pending view counts...');
            $performanceService->flushViewCounts();
            $this->info('✓ View counts flushed');
        }

        // If no specific options, run all optimizations
        if (! $this->option('warm-cache') && ! $this->option('clear-cache') && ! $this->option('database') && ! $this->option('flush-views')) {
            $this->info('Running full optimization...');

            $this->info('1/4: Clearing caches...');
            $performanceService->clearAllCaches();

            $this->info('2/4: Warming caches...');
            $performanceService->warmCache();

            $this->info('3/4: Optimizing database...');
            $performanceService->optimizeDatabase();

            $this->info('4/4: Flushing view counts...');
            $performanceService->flushViewCounts();
        }

        // Show cache statistics
        $stats = $performanceService->getCacheStats();
        $this->newLine();
        $this->info('Performance Statistics:');
        $this->table(
            ['Metric', 'Value'],
            collect($stats)->map(fn ($value, $key) => [
                ucwords(str_replace('_', ' ', $key)),
                is_numeric($value) ? number_format($value) : $value,
            ])->toArray()
        );

        $this->newLine();
        $this->info('✓ Performance optimization completed!');

        return self::SUCCESS;
    }
}
