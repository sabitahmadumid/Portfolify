<?php

namespace App\Filament\Admin\Resources\Portfolios\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Awcodes\Curator\Components\Forms\CuratorPicker;

class PortfolioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Portfolio')
                    ->tabs([
                        Tabs\Tab::make('Content')
                            ->schema([
                                Section::make('Basic Information')
                                    ->schema([
                                        TextInput::make('title')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                                        TextInput::make('slug')
                                            ->required()
                                            ->unique(ignoreRecord: true),
                                        TextInput::make('client')
                                            ->placeholder('Client name'),
                                        DatePicker::make('project_date')
                                            ->label('Project Date'),
                                    ])
                                    ->columns(2),
                                
                                Section::make('Description & Content')
                                    ->schema([
                                        Textarea::make('description')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        RichEditor::make('content')
                                            ->toolbarButtons([
                                                'attachFiles',
                                                'blockquote',
                                                'bold',
                                                'bulletList',
                                                'codeBlock',
                                                'h2',
                                                'h3',
                                                'italic',
                                                'link',
                                                'orderedList',
                                                'redo',
                                                'strike',
                                                'underline',
                                                'undo',
                                            ])
                                            ->columnSpanFull(),
                                    ]),
                                
                                Section::make('Technologies & Links')
                                    ->schema([
                                        TagsInput::make('technologies')
                                            ->placeholder('Add technologies used')
                                            ->columnSpanFull(),
                                        TextInput::make('project_url')
                                            ->url()
                                            ->label('Project URL')
                                            ->placeholder('https://example.com'),
                                        TextInput::make('github_url')
                                            ->url()
                                            ->label('GitHub URL')
                                            ->placeholder('https://github.com/username/repo'),
                                    ])
                                    ->columns(2),
                            ]),
                        
                        Tabs\Tab::make('Media')
                            ->schema([
                                Section::make('Images')
                                    ->schema([
                                        CuratorPicker::make('featured_image')
                                            ->label('Featured Image')
                                            ->buttonLabel('Select Image')
                                            ->size('lg'),
                                        CuratorPicker::make('gallery_images')
                                            ->label('Gallery Images')
                                            ->multiple()
                                            ->buttonLabel('Select Images')
                                            ->size('lg'),
                                    ])
                                    ->columns(1),
                            ]),
                        
                        Tabs\Tab::make('Settings')
                            ->schema([
                                Section::make('Visibility')
                                    ->schema([
                                        Toggle::make('is_published')
                                            ->label('Published')
                                            ->default(false),
                                        Toggle::make('is_featured')
                                            ->label('Featured')
                                            ->default(false),
                                        TextInput::make('sort_order')
                                            ->label('Sort Order')
                                            ->numeric()
                                            ->default(0),
                                    ])
                                    ->columns(3),
                            ]),
                        
                        Tabs\Tab::make('SEO')
                            ->schema([
                                Section::make('Meta Data')
                                    ->schema([
                                        TextInput::make('meta_title')
                                            ->label('Meta Title')
                                            ->placeholder('Leave empty to use title'),
                                        Textarea::make('meta_description')
                                            ->label('Meta Description')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        TagsInput::make('meta_keywords')
                                            ->label('Meta Keywords')
                                            ->placeholder('Add keywords')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
