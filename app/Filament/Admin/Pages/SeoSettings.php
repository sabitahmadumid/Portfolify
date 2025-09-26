<?php

namespace App\Filament\Admin\Pages;

use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Inerba\DbConfig\AbstractPageSettings;

class SeoSettings extends AbstractPageSettings
{
    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    protected static ?string $title = 'SEO Settings';

    protected static ?string $slug = 'seo-settings';

    protected string $view = 'filament.pages.seo-settings';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'SEO & Analytics';

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-magnifying-glass';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Settings';
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    protected function settingName(): string
    {
        return 'seo';
    }

    /**
     * Provide default values.
     *
     * @return array<string, mixed>
     */
    public function getDefaultData(): array
    {
        return [
            'enable_schema_markup' => true,
            'enable_open_graph' => true,
            'enable_twitter_cards' => true,
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Meta Tags')
                    ->schema([
                        TextInput::make('default_meta_title')
                            ->label('Default Meta Title')
                            ->helperText('Default title for pages without a specific title'),
                            
                        Textarea::make('default_meta_description')
                            ->label('Default Meta Description')
                            ->helperText('Default description for pages without a specific description')
                            ->rows(3),
                            
                        TagsInput::make('default_meta_keywords')
                            ->label('Default Meta Keywords')
                            ->helperText('Keywords for SEO'),
                    ]),
                    
                Section::make('Open Graph & Social')
                    ->schema([
                        Toggle::make('enable_open_graph')
                            ->label('Enable Open Graph Tags'),
                            
                        Toggle::make('enable_twitter_cards')
                            ->label('Enable Twitter Cards'),
                            
                        TextInput::make('og_image')
                            ->label('Default Open Graph Image URL')
                            ->url(),
                            
                        TextInput::make('twitter_handle')
                            ->label('Twitter Handle')
                            ->prefix('@'),
                    ]),
                    
                Section::make('Schema Markup')
                    ->schema([
                        Toggle::make('enable_schema_markup')
                            ->label('Enable Schema Markup'),
                    ]),
                    
                Section::make('Search Engines')
                    ->schema([
                        TextInput::make('google_site_verification')
                            ->label('Google Site Verification Code')
                            ->helperText('Google Search Console verification code'),
                            
                        TextInput::make('bing_site_verification')
                            ->label('Bing Site Verification Code')
                            ->helperText('Bing Webmaster Tools verification code'),
                            
                        TextInput::make('google_analytics_id')
                            ->label('Google Analytics ID')
                            ->helperText('Google Analytics tracking ID (GA4)'),
                    ]),
                    
                Section::make('Custom Code')
                    ->schema([
                        Textarea::make('custom_head_code')
                            ->label('Custom Head Code')
                            ->helperText('Custom HTML code to insert in the <head> section')
                            ->rows(5),
                            
                        Textarea::make('custom_body_code')
                            ->label('Custom Body Code')  
                            ->helperText('Custom HTML code to insert before </body>')
                            ->rows(5),
                    ]),
            ])
            ->statePath('data');
    }
}
