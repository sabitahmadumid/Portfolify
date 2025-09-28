<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Post;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VisitorStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Get total views from all posts
        $totalViews = Post::sum('views_count') ?? 0;

        // Get this month's views (approximate)
        $thisMonthViews = Post::where('created_at', '>=', now()->startOfMonth())
            ->sum('views_count') ?? 0;

        // Get most viewed post
        $mostViewedPost = Post::orderBy('views_count', 'desc')->first();
        $topPostViews = $mostViewedPost?->views_count ?? 0;

        // Calculate average views per post
        $postCount = Post::count();
        $avgViews = $postCount > 0 ? round($totalViews / $postCount) : 0;

        return [
            Stat::make('Total Page Views', number_format($totalViews))
                ->description('All-time blog views')
                ->descriptionIcon('heroicon-o-eye')
                ->color(Color::Blue)
                ->chart([50, 75, 90, 120, 150, 180, 200, 225])
                ->chartColor(Color::Blue),

            Stat::make('This Month Views', number_format($thisMonthViews))
                ->description('Current month traffic')
                ->descriptionIcon('heroicon-o-calendar-days')
                ->color(Color::Green)
                ->chart([10, 25, 35, 45, 60, 75, 90, 100])
                ->chartColor(Color::Green),

            Stat::make('Top Post Views', number_format($topPostViews))
                ->description($mostViewedPost ? "'{$mostViewedPost->title}'" : 'No posts yet')
                ->descriptionIcon('heroicon-o-fire')
                ->color(Color::Red)
                ->chart([5, 15, 25, 40, 60, 80, 100, $topPostViews])
                ->chartColor(Color::Red),

            Stat::make('Avg Views per Post', number_format($avgViews))
                ->description('Content performance')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color(Color::Purple)
                ->chart([5, 8, 12, 15, 20, 25, 30, $avgViews])
                ->chartColor(Color::Purple),
        ];
    }
}
