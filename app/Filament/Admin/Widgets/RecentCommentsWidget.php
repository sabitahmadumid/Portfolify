<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Comment;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Support\Colors\Color;

class RecentCommentsWidget extends BaseWidget
{
    protected static ?string $heading = 'Recent Comments';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Comment::query()
                    ->with(['post', 'user'])
                    ->latest()
                    ->limit(8)
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label('Author')
                    ->default('Anonymous')
                    ->sortable(),

                TextColumn::make('post.title')
                    ->label('Post')
                    ->limit(40)
                    ->sortable(),

                TextColumn::make('content')
                    ->label('Comment')
                    ->limit(60)
                    ->wrap(),

                TextColumn::make('is_approved')
                    ->label('Status')
                    ->badge()
                    ->color(fn (bool $state): string => match ($state) {
                        true => 'success',
                        false => 'warning',
                    })
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Approved' : 'Pending'),

                TextColumn::make('created_at')
                    ->label('Posted')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}