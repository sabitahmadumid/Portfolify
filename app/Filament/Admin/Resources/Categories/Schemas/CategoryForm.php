<?php

namespace App\Filament\Admin\Resources\Categories\Schemas;

use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Appearance')
                    ->schema([
                        ColorPicker::make('color')
                            ->label('Category Color')
                            ->default('#3B82F6'),
                        Select::make('icon')
                            ->label('Icon')
                            ->options([
                                'academic-cap' => 'Academic Cap',
                                'code-bracket' => 'Code Bracket',
                                'computer-desktop' => 'Computer Desktop',
                                'device-phone-mobile' => 'Mobile',
                                'lightbulb' => 'Light Bulb',
                                'rocket-launch' => 'Rocket',
                                'sparkles' => 'Sparkles',
                                'star' => 'Star',
                            ])
                            ->searchable(),
                        CuratorPicker::make('featured_image')
                            ->label('Featured Image')
                            ->buttonLabel('Select Image'),
                    ])
                    ->columns(3),

                Section::make('Settings')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),

                Section::make('SEO')
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->placeholder('Leave empty to use category name'),
                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
