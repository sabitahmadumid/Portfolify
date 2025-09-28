<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;

class CategoryDistributionChart extends ChartWidget
{
    protected static ?int $sort = 4;

    public function getHeading(): string
    {
        return 'Posts by Category';
    }

    protected function getData(): array
    {
        $categories = Category::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit(8)
            ->get();

        return [
            'datasets' => [
                [
                    'data' => $categories->pluck('posts_count')->toArray(),
                    'backgroundColor' => [
                        'rgb(59, 130, 246)',   // Blue
                        'rgb(16, 185, 129)',   // Green
                        'rgb(139, 92, 246)',   // Purple
                        'rgb(245, 101, 101)',  // Red
                        'rgb(251, 191, 36)',   // Yellow
                        'rgb(236, 72, 153)',   // Pink
                        'rgb(20, 184, 166)',   // Teal
                        'rgb(156, 163, 175)',  // Gray
                    ],
                    'borderWidth' => 0,
                ],
            ],
            'labels' => $categories->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }
}
