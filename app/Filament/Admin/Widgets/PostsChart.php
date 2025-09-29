<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Post;
use Carbon\Carbon;
use Filament\Widgets\LineChartWidget;

class PostsChart extends LineChartWidget
{
    protected ?string $heading = 'Posts Published Over Time';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = $this->getPostsPerMonth();

        return [
            'datasets' => [
                [
                    'label' => 'Posts Published',
                    'data' => $data['posts'],
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    private function getPostsPerMonth(): array
    {
        $months = collect();
        $posts = collect();

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months->push($date->format('M Y'));

            $postCount = Post::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $posts->push($postCount);
        }

        return [
            'labels' => $months->toArray(),
            'posts' => $posts->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
