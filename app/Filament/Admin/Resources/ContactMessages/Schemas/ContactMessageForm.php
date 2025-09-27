<?php

namespace App\Filament\Admin\Resources\ContactMessages\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Contact Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Full Name')
                                    ->required()
                                    ->maxLength(100)
                                    ->disabled(),

                                TextInput::make('email')
                                    ->label('Email Address')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->disabled(),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Select::make('subject')
                                    ->label('Subject')
                                    ->options([
                                        'project' => 'New Project Inquiry',
                                        'collaboration' => 'Collaboration Opportunity',
                                        'consultation' => 'Consultation Request',
                                        'support' => 'Technical Support',
                                        'other' => 'Other',
                                    ])
                                    ->disabled(),

                                Select::make('budget')
                                    ->label('Budget Range')
                                    ->options([
                                        'under-5k' => 'Under $5,000',
                                        '5k-10k' => '$5,000 - $10,000',
                                        '10k-25k' => '$10,000 - $25,000',
                                        '25k-50k' => '$25,000 - $50,000',
                                        '50k-plus' => '$50,000+',
                                        'discuss' => 'Let\'s discuss',
                                    ])
                                    ->disabled(),
                            ]),
                    ]),

                Section::make('Message')
                    ->schema([
                        Textarea::make('message')
                            ->label('Message')
                            ->required()
                            ->maxLength(2000)
                            ->rows(6)
                            ->disabled(),
                    ]),

                Section::make('Status & Metadata')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'new' => 'New',
                                        'read' => 'Read',
                                        'replied' => 'Replied',
                                        'resolved' => 'Resolved',
                                    ])
                                    ->required(),

                                TextInput::make('ip_address')
                                    ->label('IP Address')
                                    ->disabled(),
                            ]),
                    ])
                    ->collapsible(),
            ]);
    }
}
