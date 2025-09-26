<?php

namespace App\Filament\Admin\Pages;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Inerba\DbConfig\AbstractPageSettings;

class GeneralSettings extends AbstractPageSettings
{
    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    protected static ?string $title = 'General Settings';

    protected static ?string $slug = 'general-settings';

    protected string $view = 'filament.pages.general-settings';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'General';

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-wrench-screwdriver';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Settings';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    protected function settingName(): string
    {
        return 'general';
    }

    /**
     * Provide default values.
     *
     * @return array<string, mixed>
     */
    public function getDefaultData(): array
    {
        return [
            'site_name' => 'Portfolify',
            'site_description' => 'Professional portfolio website showcasing creative work and insights',
            'contact_email' => 'hello@portfolify.com',
            'primary_color' => '#3B82F6',
            'secondary_color' => '#8B5CF6',
            'dark_mode_enabled' => true,
            'default_theme' => 'system',
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Site Information')
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Site Name')
                            ->required()
                            ->maxLength(255),
                        
                        Textarea::make('site_description')
                            ->label('Site Description')
                            ->required()
                            ->rows(3),
                            
                        TextInput::make('site_keywords')
                            ->label('Site Keywords')
                            ->helperText('Comma-separated keywords for SEO'),
                    ]),
                    
                Section::make('Contact Information')
                    ->schema([
                        TextInput::make('contact_email')
                            ->label('Contact Email')
                            ->email()
                            ->required(),
                            
                        TextInput::make('contact_phone')
                            ->label('Contact Phone')
                            ->tel(),
                            
                        Textarea::make('contact_address')
                            ->label('Contact Address')
                            ->rows(3),
                    ]),
                    
                Section::make('Social Media')
                    ->schema([
                        TextInput::make('social_twitter')
                            ->label('Twitter URL')
                            ->url()
                            ->prefix('https://'),
                            
                        TextInput::make('social_linkedin')
                            ->label('LinkedIn URL')
                            ->url()
                            ->prefix('https://'),
                            
                        TextInput::make('social_github')
                            ->label('GitHub URL')
                            ->url()
                            ->prefix('https://'),
                            
                        TextInput::make('social_instagram')
                            ->label('Instagram URL')
                            ->url()
                            ->prefix('https://'),
                    ]),
                    
                Section::make('Appearance')
                    ->schema([
                        ColorPicker::make('primary_color')
                            ->label('Primary Color'),
                            
                        ColorPicker::make('secondary_color')
                            ->label('Secondary Color'),
                            
                        Toggle::make('dark_mode_enabled')
                            ->label('Enable Dark Mode'),
                            
                        Select::make('default_theme')
                            ->label('Default Theme')
                            ->options([
                                'light' => 'Light',
                                'dark' => 'Dark',
                                'system' => 'System Preference',
                            ]),
                    ]),
            ])
            ->statePath('data');
    }
}
