<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class SystemInfoWidget extends Widget
{
    protected string $view = 'filament.admin.widgets.system-info';

    protected static ?int $sort = 6;

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'phpVersion' => PHP_VERSION,
            'laravelVersion' => app()->version(),
            'databaseConnection' => DB::connection()->getName(),
            'uptime' => $this->getSystemUptime(),
            'memoryUsage' => $this->getMemoryUsage(),
        ];
    }

    private function getSystemUptime(): string
    {
        if (function_exists('sys_getloadavg')) {
            $uptime = shell_exec('uptime -p');

            return $uptime ? trim($uptime) : 'N/A';
        }

        return 'N/A';
    }

    private function getMemoryUsage(): string
    {
        $bytes = memory_get_usage(true);
        $mb = round($bytes / 1024 / 1024, 2);

        return $mb.' MB';
    }
}
