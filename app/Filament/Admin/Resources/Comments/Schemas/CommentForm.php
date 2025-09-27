<?php

namespace App\Filament\Admin\Resources\Comments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('post_id')
                    ->relationship('post', 'title')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name'),
                Select::make('parent_id')
                    ->relationship('parent', 'id'),
                TextInput::make('author_name'),
                TextInput::make('author_email')
                    ->email(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('is_approved')
                    ->required(),
                TextInput::make('ip_address'),
                TextInput::make('user_agent'),
            ]);
    }
}
