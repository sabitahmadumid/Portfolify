<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Support\Colors\Color;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Posts', Post::count())
                ->description('Published blog posts')
                ->descriptionIcon('heroicon-o-document-text')
                ->color(Color::Blue)
                ->chart([7, 3, 4, 5, 6, 3, 5, 3])
                ->chartColor(Color::Blue),

            Stat::make('Portfolio Projects', Portfolio::count())
                ->description('Showcase projects')
                ->descriptionIcon('heroicon-o-briefcase')
                ->color(Color::Purple)
                ->chart([2, 3, 1, 4, 2, 5, 3, 4])
                ->chartColor(Color::Purple),

            Stat::make('Total Users', User::count())
                ->description('Registered users')
                ->descriptionIcon('heroicon-o-users')
                ->color(Color::Green)
                ->chart([1, 2, 1, 3, 2, 4, 3, 5])
                ->chartColor(Color::Green),

            Stat::make('Comments', Comment::count())
                ->description('User engagement')
                ->descriptionIcon('heroicon-o-chat-bubble-left-right')
                ->color(Color::Orange)
                ->chart([5, 8, 12, 15, 18, 22, 25, 28])
                ->chartColor(Color::Orange),

            Stat::make('Categories', Category::count())
                ->description('Content organization')
                ->descriptionIcon('heroicon-o-tag')
                ->color(Color::Indigo)
                ->chart([1, 1, 2, 2, 3, 3, 4, 4])
                ->chartColor(Color::Indigo),

            Stat::make('Published Posts', Post::where('is_published', true)->count())
                ->description('Live content')
                ->descriptionIcon('heroicon-o-eye')
                ->color(Color::Emerald)
                ->chart([5, 7, 8, 10, 12, 14, 16, 18])
                ->chartColor(Color::Emerald),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }
}