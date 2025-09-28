<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Post;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;

class TopPerformingPostsWidget extends BaseWidget
{
    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = 'full';

    public function getTableHeading(): string
    {
        return 'Top Performing Posts';
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                Post::query()
                    ->withCount('comments')
                    ->where('is_published', true)
                    ->orderByDesc('views_count')
                    ->limit(6)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Post Title')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(function (Post $record): string {
                        return $record->title;
                    }),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('Views')
                    ->sortable()
                    ->numeric()
                    ->alignEnd()
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('comments_count')
                    ->label('Comments')
                    ->numeric()
                    ->alignEnd()
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color(fn (Post $record) => $record->category?->color ?? 'gray'),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Published')
                    ->date()
                    ->sortable(),
            ])
            ->actions($this->getTableActions())
            ->defaultSort('views_count', 'desc');
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('view')
                ->label('View')
                ->icon('heroicon-o-eye')
                ->url(fn (Post $record) => route('blog.show', $record->slug))
                ->openUrlInNewTab(),

            Action::make('edit')
                ->label('Edit')
                ->icon('heroicon-o-pencil')
                ->url(fn (Post $record) => route('filament.admin.resources.posts.edit', $record))
                ->color('warning'),
        ];
    }
}
