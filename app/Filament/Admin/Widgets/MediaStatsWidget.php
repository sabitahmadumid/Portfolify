<?php

namespace App\Filament\Admin\Widgets;

use Awcodes\Curator\Models\Media;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MediaStatsWidget extends BaseWidget
{
    protected ?string $heading = 'Media Library';

    protected static ?int $sort = 5;

    protected function getStats(): array
    {
        $totalMedia = Media::count();
        $totalSizeBytes = Media::sum('size');
        $totalSizeMB = round($totalSizeBytes / 1024 / 1024, 2);

        return [
            Stat::make('Total Files', $totalMedia)
                ->description('Media library files')
                ->descriptionIcon('heroicon-o-photo')
                ->color(Color::Cyan),

            Stat::make('Storage Used', $totalSizeMB.' MB')
                ->description('Total file size')
                ->descriptionIcon('heroicon-o-cloud-arrow-up')
                ->color(Color::Indigo),

            Stat::make('Images', Media::where('type', 'image')->count())
                ->description('Image files')
                ->descriptionIcon('heroicon-o-photo')
                ->color(Color::Green),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }
}
