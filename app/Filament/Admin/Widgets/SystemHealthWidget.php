<?php

namespace App\Filament\Admin\Widgets;

use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

/**
 * System Resource Monitoring Widget
 * 
 * Displays real-time system resource usage including disk and memory consumption.
 * Complementary to SystemInfoWidget which shows system version information.
 */
class SystemHealthWidget extends BaseWidget
{
    protected static ?int $sort = 9;

    public function getPollingInterval(): ?string
    {
        return '30s';
    }

    protected function getStats(): array
    {
        // Get system resource information
        $diskUsage = $this->getDiskUsage();
        $memoryUsage = $this->getMemoryUsage();

        return [
            Stat::make('Disk Usage', $diskUsage['percentage'].'%')
                ->description($diskUsage['description'])
                ->descriptionIcon('heroicon-o-server')
                ->color($this->getDiskUsageColor($diskUsage['percentage']))
                ->chart($this->generateDiskChart($diskUsage['percentage'])),

            Stat::make('Memory Usage', $memoryUsage['percentage'].'%')
                ->description($memoryUsage['description'])
                ->descriptionIcon('heroicon-o-cpu-chip')
                ->color($this->getMemoryUsageColor($memoryUsage['percentage']))
                ->chart($this->generateMemoryChart($memoryUsage['percentage'])),
        ];
    }

    private function getDiskUsage(): array
    {
        $bytes = disk_total_space(base_path());
        $freeBytes = disk_free_space(base_path());
        $usedBytes = $bytes - $freeBytes;

        $percentage = $bytes > 0 ? round(($usedBytes / $bytes) * 100, 1) : 0;

        return [
            'percentage' => $percentage,
            'description' => $this->formatBytes($usedBytes).' / '.$this->formatBytes($bytes),
        ];
    }

    private function getMemoryUsage(): array
    {
        $memoryLimit = $this->convertToBytes(ini_get('memory_limit'));
        $memoryUsed = memory_get_usage(true);

        $percentage = $memoryLimit > 0 ? round(($memoryUsed / $memoryLimit) * 100, 1) : 0;

        return [
            'percentage' => $percentage,
            'description' => $this->formatBytes($memoryUsed).' / '.$this->formatBytes($memoryLimit),
        ];
    }

    private function convertToBytes(string $value): int
    {
        $value = trim($value);
        $last = strtolower($value[strlen($value) - 1]);
        $value = (int) $value;

        switch ($last) {
            case 'g':
                $value *= 1024;
            case 'm':
                $value *= 1024;
            case 'k':
                $value *= 1024;
        }

        return $value;
    }

    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision).' '.$units[$i];
    }

    private function getDiskUsageColor(float $percentage): string
    {
        if ($percentage >= 90) {
            return 'danger';
        }
        if ($percentage >= 75) {
            return 'warning';
        }
        if ($percentage >= 50) {
            return 'info';
        }

        return 'success';
    }

    private function getMemoryUsageColor(float $percentage): string
    {
        if ($percentage >= 85) {
            return 'danger';
        }
        if ($percentage >= 70) {
            return 'warning';
        }
        if ($percentage >= 50) {
            return 'info';
        }

        return 'success';
    }

    private function generateDiskChart(float $percentage): array
    {
        return [
            max(0, $percentage - 30),
            max(0, $percentage - 20),
            max(0, $percentage - 10),
            $percentage,
        ];
    }

    private function generateMemoryChart(float $percentage): array
    {
        return [
            max(0, $percentage - 25),
            max(0, $percentage - 15),
            max(0, $percentage - 5),
            $percentage,
        ];
    }
}
