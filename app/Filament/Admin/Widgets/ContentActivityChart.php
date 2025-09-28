<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Filament\Widgets\ChartWidget;

class ContentActivityChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function getHeading(): string
    {
        return 'Content Activity Over Time';
    }

    protected function getData(): array
    {
        // Get data for the last 12 months
        $months = collect(range(0, 11))->map(function ($month) {
            return now()->subMonths($month)->format('M Y');
        })->reverse()->values();

        $postsData = collect(range(0, 11))->map(function ($month) {
            return Post::whereYear('created_at', now()->subMonths($month)->year)
                ->whereMonth('created_at', now()->subMonths($month)->month)
                ->count();
        })->reverse()->values();

        $commentsData = collect(range(0, 11))->map(function ($month) {
            return Comment::whereYear('created_at', now()->subMonths($month)->year)
                ->whereMonth('created_at', now()->subMonths($month)->month)
                ->count();
        })->reverse()->values();

        $usersData = collect(range(0, 11))->map(function ($month) {
            return User::whereYear('created_at', now()->subMonths($month)->year)
                ->whereMonth('created_at', now()->subMonths($month)->month)
                ->count();
        })->reverse()->values();

        return [
            'datasets' => [
                [
                    'label' => 'Posts Published',
                    'data' => $postsData->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Comments Received',
                    'data' => $commentsData->toArray(),
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'borderColor' => 'rgb(16, 185, 129)',
                    'borderWidth' => 2,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'New Users',
                    'data' => $usersData->toArray(),
                    'backgroundColor' => 'rgba(139, 92, 246, 0.1)',
                    'borderColor' => 'rgb(139, 92, 246)',
                    'borderWidth' => 2,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $months->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
        ];
    }
}
