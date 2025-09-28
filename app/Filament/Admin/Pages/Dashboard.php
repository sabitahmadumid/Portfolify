<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Widgets\CategoryDistributionChart;
use App\Filament\Admin\Widgets\ContentActivityChart;
use App\Filament\Admin\Widgets\LatestPostsWidget;
use App\Filament\Admin\Widgets\MediaStatsWidget;
use App\Filament\Admin\Widgets\PendingCommentsWidget;
use App\Filament\Admin\Widgets\PostsChart;
use App\Filament\Admin\Widgets\QuickActionsWidget;
use App\Filament\Admin\Widgets\RecentCommentsWidget;
use App\Filament\Admin\Widgets\RecentContentWidget;
use App\Filament\Admin\Widgets\StatsOverviewWidget;
use App\Filament\Admin\Widgets\SystemHealthWidget;
use App\Filament\Admin\Widgets\SystemInfoWidget;
use App\Filament\Admin\Widgets\TopPerformingPostsWidget;
use App\Filament\Admin\Widgets\VisitorStatsWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    protected static ?int $navigationSort = -2;

    public function getWidgets(): array
    {
        return [
            // Quick actions and overview stats
            QuickActionsWidget::class,
            StatsOverviewWidget::class,
            VisitorStatsWidget::class,

            // Charts and analytics
            PostsChart::class,
            ContentActivityChart::class,
            CategoryDistributionChart::class,

            // Content management
            TopPerformingPostsWidget::class,
            LatestPostsWidget::class,
            RecentContentWidget::class,
            PendingCommentsWidget::class,
            RecentCommentsWidget::class,
            MediaStatsWidget::class,
            SystemHealthWidget::class,
            SystemInfoWidget::class,
        ];
    }

    public function getColumns(): array|int
    {
        return 2;
    }
}
