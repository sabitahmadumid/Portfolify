<?php

namespace App\Filament\Admin\Pages;

use Awcodes\Curator\Forms\Components\Curation;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Inerba\DbConfig\AbstractPageSettings;

class Settings extends AbstractPageSettings
{
    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    protected static ?string $title = 'Settings';

    protected static ?string $slug = 'settings';

    protected string $view = 'filament.admin.pages.settings';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Settings';

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-cog-6-tooth';
    }

    public function getTitle(): string
    {
        return 'Application Settings';
    }

    public function settingName(): string
    {
        return 'app_settings';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make('Settings')
                    ->tabs([
                        // General Settings Tab
                        Tabs\Tab::make('General')
                            ->icon('heroicon-o-home')
                            ->schema([
                                Section::make('Site Information')
                                    ->description('Configure your site basic information')
                                    ->schema([
                                        TextInput::make('site.name')
                                            ->label('Site Name')
                                            ->placeholder('Enter your site name')
                                            ->maxLength(255)
                                            ->required(),

                                        Textarea::make('site.description')
                                            ->label('Site Description')
                                            ->placeholder('Brief description of your site')
                                            ->rows(3)
                                            ->maxLength(500),

                                        TextInput::make('site.tagline')
                                            ->label('Site Tagline')
                                            ->placeholder('A catchy tagline for your site')
                                            ->maxLength(255),

                                        ColorPicker::make('site.primary_color')
                                            ->label('Primary Color')
                                            ->default('#3b82f6'),
                                        
                                        ColorPicker::make('site.secondary_color')
                                            ->label('Secondary Color')
                                            ->default('#64748b'),
                                    ])
                                    ->columns(2),

                                Section::make('Logo & Branding')
                                    ->description('Upload your logo and favicon')
                                    ->schema([
                                        Curation::make('site.logo')
                                            ->label('Site Logo')
                                            ->helperText('Recommended size: 250x60px')
                                            ->directory('branding')
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/svg+xml']),

                                        Curation::make('site.logo_dark')
                                            ->label('Dark Mode Logo')
                                            ->helperText('Logo for dark backgrounds')
                                            ->directory('branding')
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/svg+xml']),

                                        Curation::make('site.favicon')
                                            ->label('Favicon')
                                            ->helperText('16x16px ICO or PNG file')
                                            ->directory('branding')
                                            ->acceptedFileTypes(['image/x-icon', 'image/png']),
                                    ])
                                    ->columns(3),

                                Section::make('Contact Information')
                                    ->description('Your contact details')
                                    ->schema([
                                        TextInput::make('contact.email')
                                            ->label('Contact Email')
                                            ->email()
                                            ->placeholder('contact@yoursite.com'),

                                        TextInput::make('contact.phone')
                                            ->label('Phone Number')
                                            ->tel()
                                            ->placeholder('+1 (555) 123-4567'),

                                        Textarea::make('contact.address')
                                            ->label('Address')
                                            ->rows(3)
                                            ->placeholder('Your business address'),
                                    ])
                                    ->columns(2),

                                Section::make('Social Media')
                                    ->description('Your social media profiles')
                                    ->schema([
                                        TextInput::make('social.facebook')
                                            ->label('Facebook URL')
                                            ->url()
                                            ->placeholder('https://facebook.com/yourpage'),

                                        TextInput::make('social.twitter')
                                            ->label('Twitter/X URL')
                                            ->url()
                                            ->placeholder('https://twitter.com/youraccount'),

                                        TextInput::make('social.linkedin')
                                            ->label('LinkedIn URL')
                                            ->url()
                                            ->placeholder('https://linkedin.com/in/yourprofile'),

                                        TextInput::make('social.instagram')
                                            ->label('Instagram URL')
                                            ->url()
                                            ->placeholder('https://instagram.com/youraccount'),

                                        TextInput::make('social.github')
                                            ->label('GitHub URL')
                                            ->url()
                                            ->placeholder('https://github.com/yourusername'),

                                        TextInput::make('social.youtube')
                                            ->label('YouTube URL')
                                            ->url()
                                            ->placeholder('https://youtube.com/yourchannel'),
                                    ])
                                    ->columns(2),
                            ]),

                        // Blog Settings Tab
                        Tabs\Tab::make('Blog')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Section::make('Blog Configuration')
                                    ->description('Configure your blog settings')
                                    ->schema([
                                        Toggle::make('blog.enabled')
                                            ->label('Enable Blog')
                                            ->helperText('Turn on/off the blog functionality')
                                            ->default(true),

                                        TextInput::make('blog.posts_per_page')
                                            ->label('Posts Per Page')
                                            ->numeric()
                                            ->default(10)
                                            ->minValue(1)
                                            ->maxValue(50)
                                            ->required(),

                                        Toggle::make('blog.show_featured_posts')
                                            ->label('Show Featured Posts')
                                            ->helperText('Display featured posts section')
                                            ->default(true),

                                        TextInput::make('blog.featured_posts_count')
                                            ->label('Featured Posts Count')
                                            ->numeric()
                                            ->default(3)
                                            ->minValue(1)
                                            ->maxValue(10),
                                    ])
                                    ->columns(2),

                                Section::make('Comments')
                                    ->description('Comment system configuration')
                                    ->schema([
                                        Toggle::make('blog.comments_enabled')
                                            ->label('Enable Comments')
                                            ->helperText('Allow users to comment on posts')
                                            ->default(true),

                                        Toggle::make('blog.comments_require_approval')
                                            ->label('Require Comment Approval')
                                            ->helperText('Comments need approval before being published')
                                            ->default(true),

                                        Select::make('blog.comment_sorting')
                                            ->label('Comment Sorting')
                                            ->options([
                                                'newest' => 'Newest First',
                                                'oldest' => 'Oldest First',
                                            ])
                                            ->default('newest'),
                                    ])
                                    ->columns(2),

                                Section::make('SEO & Social')
                                    ->description('Blog SEO and social sharing')
                                    ->schema([
                                        Toggle::make('blog.auto_generate_excerpts')
                                            ->label('Auto Generate Excerpts')
                                            ->helperText('Automatically create post excerpts')
                                            ->default(true),

                                        TextInput::make('blog.excerpt_length')
                                            ->label('Excerpt Length (words)')
                                            ->numeric()
                                            ->default(55)
                                            ->minValue(10)
                                            ->maxValue(200),

                                        Toggle::make('blog.show_reading_time')
                                            ->label('Show Reading Time')
                                            ->helperText('Display estimated reading time for posts')
                                            ->default(true),
                                    ])
                                    ->columns(2),
                            ]),

                        // SEO & Analytics Tab
                        Tabs\Tab::make('SEO & Analytics')
                            ->icon('heroicon-o-chart-bar')
                            ->schema([
                                Section::make('SEO Settings')
                                    ->description('Search engine optimization settings')
                                    ->schema([
                                        TextInput::make('seo.meta_title')
                                            ->label('Default Meta Title')
                                            ->maxLength(60)
                                            ->helperText('Default title for pages without specific SEO title'),

                                        Textarea::make('seo.meta_description')
                                            ->label('Default Meta Description')
                                            ->maxLength(160)
                                            ->rows(3)
                                            ->helperText('Default description for pages without specific SEO description'),

                                        TagsInput::make('seo.meta_keywords')
                                            ->label('Default Keywords')
                                            ->placeholder('Enter keywords...')
                                            ->helperText('Comma-separated keywords for your site'),

                                        TextInput::make('seo.canonical_url')
                                            ->label('Canonical URL')
                                            ->url()
                                            ->placeholder('https://yoursite.com')
                                            ->helperText('Base URL for canonical links'),
                                    ])
                                    ->columns(2),

                                Section::make('Open Graph & Twitter Cards')
                                    ->description('Social media sharing settings')
                                    ->schema([
                                        Toggle::make('seo.og_enabled')
                                            ->label('Enable Open Graph')
                                            ->helperText('Enable Facebook/LinkedIn sharing cards')
                                            ->default(true),

                                        Toggle::make('seo.twitter_cards_enabled')
                                            ->label('Enable Twitter Cards')
                                            ->helperText('Enable Twitter sharing cards')
                                            ->default(true),

                                        Curation::make('seo.default_og_image')
                                            ->label('Default OG Image')
                                            ->helperText('Default image for social sharing (1200x630px)')
                                            ->directory('seo')
                                            ->acceptedFileTypes(['image/jpeg', 'image/png']),

                                        TextInput::make('seo.twitter_site')
                                            ->label('Twitter Site Handle')
                                            ->placeholder('@yoursite')
                                            ->helperText('Your site\'s Twitter handle'),
                                    ])
                                    ->columns(2),

                                Section::make('Analytics & Tracking')
                                    ->description('Website analytics and tracking codes')
                                    ->schema([
                                        TextInput::make('analytics.google_analytics_id')
                                            ->label('Google Analytics ID')
                                            ->placeholder('GA4-XXXXXXXXXX')
                                            ->helperText('Your Google Analytics 4 measurement ID'),

                                        TextInput::make('analytics.google_tag_manager_id')
                                            ->label('Google Tag Manager ID')
                                            ->placeholder('GTM-XXXXXXX')
                                            ->helperText('Your Google Tag Manager container ID'),

                                        Textarea::make('analytics.custom_head_code')
                                            ->label('Custom Head Code')
                                            ->rows(5)
                                            ->helperText('Custom HTML/JS code to insert in <head>'),

                                        Textarea::make('analytics.custom_body_code')
                                            ->label('Custom Body Code')
                                            ->rows(5)
                                            ->helperText('Custom HTML/JS code to insert before </body>'),
                                    ])
                                    ->columns(2),
                            ]),

                        // Portfolio Settings Tab
                        Tabs\Tab::make('Portfolio')
                            ->icon('heroicon-o-briefcase')
                            ->schema([
                                Section::make('Portfolio Configuration')
                                    ->description('Configure your portfolio settings')
                                    ->schema([
                                        Toggle::make('portfolio.enabled')
                                            ->label('Enable Portfolio')
                                            ->helperText('Turn on/off the portfolio functionality')
                                            ->default(true),

                                        TextInput::make('portfolio.items_per_page')
                                            ->label('Items Per Page')
                                            ->numeric()
                                            ->default(12)
                                            ->minValue(6)
                                            ->maxValue(24)
                                            ->required(),

                                        Select::make('portfolio.default_layout')
                                            ->label('Default Layout')
                                            ->options([
                                                'grid' => 'Grid Layout',
                                                'masonry' => 'Masonry Layout',
                                                'list' => 'List Layout',
                                            ])
                                            ->default('grid'),

                                        Toggle::make('portfolio.show_categories')
                                            ->label('Show Categories Filter')
                                            ->helperText('Display category filter on portfolio page')
                                            ->default(true),
                                    ])
                                    ->columns(2),

                                Section::make('Display Options')
                                    ->description('Portfolio display preferences')
                                    ->schema([
                                        Toggle::make('portfolio.show_descriptions')
                                            ->label('Show Descriptions')
                                            ->helperText('Display project descriptions in grid view')
                                            ->default(true),

                                        Toggle::make('portfolio.show_technologies')
                                            ->label('Show Technologies')
                                            ->helperText('Display technology tags on portfolio items')
                                            ->default(true),

                                        Toggle::make('portfolio.enable_lightbox')
                                            ->label('Enable Lightbox')
                                            ->helperText('Open images in lightbox overlay')
                                            ->default(true),
                                    ])
                                    ->columns(2),
                            ]),

                        // System Settings Tab
                        Tabs\Tab::make('System')
                            ->icon('heroicon-o-server')
                            ->schema([
                                Section::make('Maintenance Mode')
                                    ->description('Site maintenance and debugging')
                                    ->schema([
                                        Toggle::make('system.maintenance_mode')
                                            ->label('Maintenance Mode')
                                            ->helperText('Put the site in maintenance mode')
                                            ->default(false),

                                        Textarea::make('system.maintenance_message')
                                            ->label('Maintenance Message')
                                            ->rows(3)
                                            ->default('We are currently performing maintenance. Please check back later.')
                                            ->helperText('Message to show during maintenance'),
                                    ])
                                    ->columns(2),

                                Section::make('Cache Settings')
                                    ->description('Performance optimization')
                                    ->schema([
                                        Toggle::make('system.cache_enabled')
                                            ->label('Enable Caching')
                                            ->helperText('Enable application-level caching')
                                            ->default(true),

                                        TextInput::make('system.cache_ttl')
                                            ->label('Cache TTL (minutes)')
                                            ->numeric()
                                            ->default(60)
                                            ->minValue(1)
                                            ->maxValue(1440)
                                            ->helperText('How long to cache data'),
                                    ])
                                    ->columns(2),

                                Section::make('Email Settings')
                                    ->description('Email configuration')
                                    ->schema([
                                        TextInput::make('mail.from_address')
                                            ->label('From Email Address')
                                            ->email()
                                            ->placeholder('noreply@yoursite.com')
                                            ->helperText('Default sender email address'),

                                        TextInput::make('mail.from_name')
                                            ->label('From Name')
                                            ->placeholder('Your Site Name')
                                            ->helperText('Default sender name'),

                                        TextInput::make('mail.reply_to')
                                            ->label('Reply To Email')
                                            ->email()
                                            ->placeholder('support@yoursite.com')
                                            ->helperText('Default reply-to email address'),
                                    ])
                                    ->columns(2),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString()
            ]);
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getUrl();
    }
}
