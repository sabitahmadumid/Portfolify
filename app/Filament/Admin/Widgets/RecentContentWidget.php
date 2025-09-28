<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Post;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentContentWidget extends BaseWidget
{
    protected static ?int $sort = 7;

    protected int|string|array $columnSpan = 'full';

    public function getTableHeading(): string
    {
        return 'Recent Content Activity';
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                Post::query()
                    ->with(['user', 'category'])
                    ->where('is_published', true)
                    ->latest()
                    ->limit(8)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(function (Post $record): string {
                        return $record->title;
                    }),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Author')
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color(fn (Post $record) => $record->category?->color ?? 'gray'),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->actions($this->getTableActions())
            ->defaultSort('created_at', 'desc');
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
