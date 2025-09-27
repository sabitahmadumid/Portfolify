<?php

namespace App\Filament\Admin\Resources\ContactMessages\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'new' => 'New',
                        'read' => 'Read',
                        'replied' => 'Replied',
                        'resolved' => 'Resolved',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'warning',
                        'read' => 'info',
                        'replied' => 'success',
                        'resolved' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Medium),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('subject_label')
                    ->label('Subject')
                    ->searchable(['subject'])
                    ->sortable(['subject']),

                TextColumn::make('budget_label')
                    ->label('Budget')
                    ->searchable(['budget'])
                    ->sortable(['budget'])
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('message')
                    ->label('Message')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= 50) {
                            return null;
                        }

                        return $state;
                    })
                    ->searchable(),

                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->copyable(),

                TextColumn::make('created_at')
                    ->label('Received At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('read_at')
                    ->label('Read At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'read' => 'Read',
                        'replied' => 'Replied',
                        'resolved' => 'Resolved',
                    ]),

                SelectFilter::make('subject')
                    ->options([
                        'project' => 'New Project Inquiry',
                        'collaboration' => 'Collaboration Opportunity',
                        'consultation' => 'Consultation Request',
                        'support' => 'Technical Support',
                        'other' => 'Other',
                    ]),

                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('markAsRead')
                    ->label('Mark as Read')
                    ->icon('heroicon-o-eye')
                    ->visible(fn ($record) => $record->status === 'new')
                    ->action(fn ($record) => $record->markAsRead())
                    ->successNotificationTitle('Message marked as read'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    Action::make('bulkMarkAsRead')
                        ->label('Mark as Read')
                        ->icon('heroicon-o-eye')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                if ($record->status !== 'read') {
                                    $record->markAsRead();
                                }
                            }
                        })
                        ->successNotificationTitle('Messages marked as read')
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s'); // Auto-refresh every 30 seconds
    }
}
