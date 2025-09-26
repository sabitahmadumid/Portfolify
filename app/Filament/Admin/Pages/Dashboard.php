<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Widgets\LatestPostsWidget;
use App\Filament\Admin\Widgets\MediaStatsWidget;
use App\Filament\Admin\Widgets\PostsChart;
use App\Filament\Admin\Widgets\QuickActionsWidget;
use App\Filament\Admin\Widgets\RecentCommentsWidget;
use App\Filament\Admin\Widgets\StatsOverviewWidget;
use App\Filament\Admin\Widgets\SystemInfoWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{


    protected static ?string $title = 'Dashboard';

    protected static ?int $navigationSort = -2;

    public function getWidgets(): array
    {
        return [
            QuickActionsWidget::class,
            StatsOverviewWidget::class,
            PostsChart::class,
            LatestPostsWidget::class,
            RecentCommentsWidget::class,
            MediaStatsWidget::class,
            SystemInfoWidget::class,
        ];
    }

    public function getColumns(): array | int
    {
        return 2;
    }
}