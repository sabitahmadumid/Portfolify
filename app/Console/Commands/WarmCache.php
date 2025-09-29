<?php

namespace App\Console\Commands;

use App\Services\PerformanceService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class WarmCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:warm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Warm application caches for better performance';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Warming application caches...');

        $performanceService = app(PerformanceService::class);

        // Warm all caches using the public method
        $performanceService->warmCache();
        $this->line('✓ All caches warmed successfully');

        $this->info('Cache warming completed successfully!');

        return CommandAlias::SUCCESS;
    }
}
