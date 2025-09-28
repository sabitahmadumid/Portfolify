<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Comment;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;

class PendingCommentsWidget extends BaseWidget
{
    protected static ?int $sort = 6;

    protected int|string|array $columnSpan = 'full';

    public function getTableHeading(): string
    {
        return 'Pending Comments';
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                Comment::query()
                    ->with(['post', 'user'])
                    ->where('is_approved', false)
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('author_name')
                    ->label('Author')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('author_email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('content')
                    ->label('Comment')
                    ->limit(100)
                    ->tooltip(function (Comment $record): ?string {
                        return $record->content;
                    }),

                Tables\Columns\TextColumn::make('post.title')
                    ->label('Post')
                    ->limit(30)
                    ->sortable()
                    ->url(fn (Comment $record) => $record->post ? route('blog.show', $record->post->slug) : null)
                    ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
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
            Action::make('approve')
                ->label('Approve')
                ->icon('heroicon-o-check')
                ->color('success')
                ->action(function (Comment $record) {
                    $record->update(['is_approved' => true]);
                    $this->dispatch('$refresh');
                })
                ->requiresConfirmation()
                ->modalHeading('Approve Comment')
                ->modalDescription('Are you sure you want to approve this comment?')
                ->visible(fn (Comment $record) => ! $record->is_approved),

            Action::make('delete')
                ->label('Delete')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->action(function (Comment $record) {
                    $record->delete();
                    $this->dispatch('$refresh');
                })
                ->requiresConfirmation()
                ->modalHeading('Delete Comment')
                ->modalDescription('Are you sure you want to delete this comment?')
                ->visible(fn (Comment $record) => ! $record->is_approved),

            Action::make('view_post')
                ->label('View Post')
                ->icon('heroicon-o-eye')
                ->url(fn (Comment $record) => $record->post ? route('blog.show', $record->post->slug) : null)
                ->openUrlInNewTab()
                ->visible(fn (Comment $record) => $record->post !== null),
        ];
    }
}
