<?php

namespace App\Filament\Admin\Pages;

use Awcodes\Curator\Components\Forms\CuratorPicker;
use BackedEnum;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;
use Inerba\DbConfig\AbstractPageSettings;

class Settings extends AbstractPageSettings
{
    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    protected static ?string $title = 'Settings';

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected ?string $subheading = 'Manage your application settings';

    protected static ?string $slug = 'settings';

    protected string $view = 'filament.pages.-settings';

    protected function settingName(): string
    {
        return 'general';
    }

    /**
     * Override mount to load data from multiple groups
     */
    public function mount(): void
    {
        $this->form->fill($this->getFormData());
    }

    /**
     * Load data from multiple db config groups using direct database queries
     */
    public function getFormData(): array
    {
        // Get all settings directly from database since db_config helper is broken
        $generalSettings = $this->getSettingsForGroup('general');
        $blogSettings = $this->getSettingsForGroup('blog');
        $seoSettings = $this->getSettingsForGroup('seo');

        return [
            // General/Site settings
            'site_name' => $generalSettings['site_name'] ?? config('app.name'),
            'site_description' => $generalSettings['site_description'] ?? 'Professional portfolio website',
            'site_tagline' => $generalSettings['site_tagline'] ?? '',
            'primary_color' => $generalSettings['primary_color'] ?? '#3B82F6',
            'secondary_color' => $generalSettings['secondary_color'] ?? '#8B5CF6',
            'site_logo' => $generalSettings['site_logo'] ?? null,
            'site_logo_dark' => $generalSettings['site_logo_dark'] ?? null,
            'site_favicon' => $generalSettings['site_favicon'] ?? null,
            'profile_image' => $generalSettings['profile_image'] ?? null,

            // Contact settings
            'contact_email' => $generalSettings['contact_email'] ?? 'hello@example.com',
            'contact_phone' => $generalSettings['contact_phone'] ?? '',
            'contact_address' => $generalSettings['contact_address'] ?? '',

            // Social settings
            'social_facebook' => $generalSettings['social_facebook'] ?? '',
            'social_twitter' => $generalSettings['social_twitter'] ?? '',
            'social_linkedin' => $generalSettings['social_linkedin'] ?? '',
            'social_instagram' => $generalSettings['social_instagram'] ?? '',
            'social_github' => $generalSettings['social_github'] ?? '',
            'social_youtube' => $generalSettings['social_youtube'] ?? '',

            // Blog settings
            'enabled' => $blogSettings['enabled'] ?? true,
            'posts_per_page' => $blogSettings['posts_per_page'] ?? 10,
            'show_featured_posts' => $blogSettings['show_featured_on_homepage'] ?? true,
            'featured_posts_count' => $blogSettings['featured_posts_count'] ?? 3,
            'allow_comments' => $blogSettings['allow_comments'] ?? true,
            'moderate_comments' => $blogSettings['moderate_comments'] ?? true,
            'notify_on_comment' => $blogSettings['notify_on_comment'] ?? true,
            'show_author_bio' => $blogSettings['show_author_bio'] ?? true,
            'show_related_posts' => $blogSettings['show_related_posts'] ?? true,
            'related_posts_count' => $blogSettings['related_posts_count'] ?? 3,
            'enable_tags' => $blogSettings['enable_tags'] ?? true,
            'enable_reading_time' => $blogSettings['enable_reading_time'] ?? true,
            'date_format' => $blogSettings['date_format'] ?? 'M j, Y',

            // SEO settings
            'meta_title' => $seoSettings['default_meta_title'] ?? config('app.name'),
            'meta_description' => $seoSettings['default_meta_description'] ?? '',
            'meta_keywords' => $seoSettings['default_meta_keywords'] ?? [],
            'enable_open_graph' => $seoSettings['enable_open_graph'] ?? true,
            'enable_twitter_cards' => $seoSettings['enable_twitter_cards'] ?? true,
            'enable_schema_markup' => $seoSettings['enable_schema_markup'] ?? true,
            'og_image' => $seoSettings['og_image'] ?? null,
            'twitter_handle' => $seoSettings['twitter_handle'] ?? '',
            'google_site_verification' => $seoSettings['google_site_verification'] ?? '',
            'bing_site_verification' => $seoSettings['bing_site_verification'] ?? '',
            'google_analytics_id' => $seoSettings['google_analytics_id'] ?? '',
            'custom_head_code' => $seoSettings['custom_head_code'] ?? '',
            'custom_body_code' => $seoSettings['custom_body_code'] ?? '',
        ];
    }

    /**
     * Override save to handle multiple groups
     */
    public function save(): void
    {
        $data = $this->form->getState();

        // Save general settings
        $this->saveToGroup('general', [
            'site_name' => $data['site_name'] ?? null,
            'site_description' => $data['site_description'] ?? null,
            'site_tagline' => $data['site_tagline'] ?? null,
            'primary_color' => $data['primary_color'] ?? '#3B82F6',
            'secondary_color' => $data['secondary_color'] ?? '#8B5CF6',
            'site_logo' => $data['site_logo'] ?? null,
            'site_logo_dark' => $data['site_logo_dark'] ?? null,
            'site_favicon' => $data['site_favicon'] ?? null,
            'profile_image' => $data['profile_image'] ?? null,
            'contact_email' => $data['contact_email'] ?? null,
            'contact_phone' => $data['contact_phone'] ?? null,
            'contact_address' => $data['contact_address'] ?? null,
            'social_facebook' => $data['social_facebook'] ?? null,
            'social_twitter' => $data['social_twitter'] ?? null,
            'social_linkedin' => $data['social_linkedin'] ?? null,
            'social_instagram' => $data['social_instagram'] ?? null,
            'social_github' => $data['social_github'] ?? null,
            'social_youtube' => $data['social_youtube'] ?? null,
        ]);

        // Save blog settings
        $this->saveToGroup('blog', [
            'enabled' => $data['enabled'] ?? true,
            'posts_per_page' => $data['posts_per_page'] ?? 10,
            'show_featured_on_homepage' => $data['show_featured_posts'] ?? true,
            'featured_posts_count' => $data['featured_posts_count'] ?? 3,
            'allow_comments' => $data['allow_comments'] ?? true,
            'moderate_comments' => $data['moderate_comments'] ?? true,
            'notify_on_comment' => $data['notify_on_comment'] ?? true,
            'show_author_bio' => $data['show_author_bio'] ?? true,
            'show_related_posts' => $data['show_related_posts'] ?? true,
            'related_posts_count' => $data['related_posts_count'] ?? 3,
            'enable_tags' => $data['enable_tags'] ?? true,
            'enable_reading_time' => $data['enable_reading_time'] ?? true,
            'date_format' => $data['date_format'] ?? 'M j, Y',
        ]);

        // Save SEO settings
        $this->saveToGroup('seo', [
            'default_meta_title' => $data['meta_title'] ?? null,
            'default_meta_description' => $data['meta_description'] ?? null,
            'default_meta_keywords' => $data['meta_keywords'] ?? [],
            'enable_open_graph' => $data['enable_open_graph'] ?? true,
            'enable_twitter_cards' => $data['enable_twitter_cards'] ?? true,
            'enable_schema_markup' => $data['enable_schema_markup'] ?? true,
            'og_image' => $data['og_image'] ?? null,
            'twitter_handle' => $data['twitter_handle'] ?? null,
            'google_site_verification' => $data['google_site_verification'] ?? null,
            'bing_site_verification' => $data['bing_site_verification'] ?? null,
            'google_analytics_id' => $data['google_analytics_id'] ?? null,
            'custom_head_code' => $data['custom_head_code'] ?? null,
            'custom_body_code' => $data['custom_body_code'] ?? null,
        ]);

        \Filament\Notifications\Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }

    /**
     * Get all settings for a specific group from database
     */
    private function getSettingsForGroup(string $group): array
    {
        $settings = [];
        $tableName = config('db-config.table_name', 'db_config');

        DB::table($tableName)->where('group', $group)->get()->each(function (\stdClass $setting) use (&$settings) {
            $settings[$setting->key] = json_decode($setting->settings, true);
        });

        return $settings;
    }

    /**
     * Save settings to a specific group
     */
    private function saveToGroup(string $group, array $settings): void
    {
        foreach ($settings as $key => $value) {
            // Always save the value, including null values (for clearing CuratorPicker fields)
            DB::table('db_config')
                ->updateOrInsert(
                    ['group' => $group, 'key' => $key],
                    ['settings' => json_encode($value), 'updated_at' => now()]
                );
        }
    }

    /**
     * Provide default values.
     *
     * @return array<string, mixed>
     */
    public function getDefaultData(): array
    {
        return [];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Settings')
                    ->tabs([
                        // General Settings Tab
                        Tabs\Tab::make('General')
                            ->icon('heroicon-o-home')
                            ->schema([
                                Section::make('Site Information')
                                    ->description('Configure your site basic information')
                                    ->schema([
                                        TextInput::make('site_name')
                                            ->label('Site Name')
                                            ->placeholder('Enter your site name')
                                            ->maxLength(255)
                                            ->required(),

                                        Textarea::make('site_description')
                                            ->label('Site Description')
                                            ->placeholder('Brief description of your site')
                                            ->rows(3)
                                            ->maxLength(500),

                                        TextInput::make('site_tagline')
                                            ->label('Site Tagline')
                                            ->placeholder('A catchy tagline for your site')
                                            ->maxLength(255),

                                        ColorPicker::make('primary_color')
                                            ->label('Primary Color'),

                                        ColorPicker::make('secondary_color')
                                            ->label('Secondary Color'),
                                    ])
                                    ->columns(2),

                                Section::make('Logo & Branding')
                                    ->description('Upload your logo and branding assets')
                                    ->schema([
                                        CuratorPicker::make('site_logo')
                                            ->label('Site Logo')
                                            ->helperText('Recommended size: 250x60px')
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/svg+xml']),

                                        CuratorPicker::make('site_logo_dark')
                                            ->label('Dark Mode Logo')
                                            ->helperText('Logo for dark backgrounds')
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/svg+xml']),

                                        CuratorPicker::make('site_favicon')
                                            ->label('Favicon')
                                            ->helperText('16x16px ICO or PNG file')
                                            ->acceptedFileTypes(['image/x-icon', 'image/png']),

                                        CuratorPicker::make('profile_image')
                                            ->label('Profile Image')
                                            ->helperText('Your profile picture (400x400px recommended)')
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                            ->imageResizeTargetWidth(400)
                                            ->imageResizeTargetHeight(400),
                                    ])
                                    ->columns(2),

                                Section::make('Contact Information')
                                    ->description('Your contact details')
                                    ->schema([
                                        TextInput::make('contact_email')
                                            ->label('Contact Email')
                                            ->email()
                                            ->placeholder('contact@yoursite.com'),

                                        TextInput::make('contact_phone')
                                            ->label('Phone Number')
                                            ->tel()
                                            ->placeholder('+1 (555) 123-4567'),

                                        Textarea::make('contact_address')
                                            ->label('Address')
                                            ->rows(3)
                                            ->placeholder('Your business address'),
                                    ])
                                    ->columns(2),

                                Section::make('Social Media')
                                    ->description('Your social media profiles')
                                    ->schema([
                                        TextInput::make('social_facebook')
                                            ->label('Facebook URL')
                                            ->url()
                                            ->placeholder('https://facebook.com/yourpage'),

                                        TextInput::make('social_twitter')
                                            ->label('Twitter/X URL')
                                            ->url()
                                            ->placeholder('https://twitter.com/youraccount'),

                                        TextInput::make('social_linkedin')
                                            ->label('LinkedIn URL')
                                            ->url()
                                            ->placeholder('https://linkedin.com/in/yourprofile'),

                                        TextInput::make('social_instagram')
                                            ->label('Instagram URL')
                                            ->url()
                                            ->placeholder('https://instagram.com/youraccount'),

                                        TextInput::make('social_github')
                                            ->label('GitHub URL')
                                            ->url()
                                            ->placeholder('https://github.com/yourusername'),

                                        TextInput::make('social_youtube')
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
                                        Toggle::make('enabled')
                                            ->label('Enable Blog')
                                            ->helperText('Turn on/off the blog functionality'),

                                        TextInput::make('posts_per_page')
                                            ->label('Posts Per Page')
                                            ->numeric()
                                            ->minValue(1)
                                            ->maxValue(50)
                                            ->required(),

                                        Toggle::make('show_featured_posts')
                                            ->label('Show Featured Posts')
                                            ->helperText('Display featured posts section'),

                                        TextInput::make('featured_posts_count')
                                            ->label('Featured Posts Count')
                                            ->numeric()
                                            ->minValue(1)
                                            ->maxValue(10),

                                        TextInput::make('date_format')
                                            ->label('Date Format')
                                            ->placeholder('M j, Y')
                                            ->helperText('PHP date format (e.g., M j, Y for Jan 1, 2024)'),
                                    ])
                                    ->columns(2),

                                Section::make('Comments & Features')
                                    ->description('Blog features and comment system')
                                    ->schema([
                                        Toggle::make('allow_comments')
                                            ->label('Allow Comments')
                                            ->helperText('Allow users to comment on posts'),

                                        Toggle::make('moderate_comments')
                                            ->label('Moderate Comments')
                                            ->helperText('Comments need approval before being published'),

                                        Toggle::make('notify_on_comment')
                                            ->label('Notify on Comment')
                                            ->helperText('Send email notifications for new comments'),

                                        Toggle::make('show_author_bio')
                                            ->label('Show Author Bio')
                                            ->helperText('Display author biography on posts'),

                                        Toggle::make('show_related_posts')
                                            ->label('Show Related Posts')
                                            ->helperText('Display related posts section'),

                                        TextInput::make('related_posts_count')
                                            ->label('Related Posts Count')
                                            ->numeric()
                                            ->minValue(1)
                                            ->maxValue(10),

                                        Toggle::make('enable_tags')
                                            ->label('Enable Tags')
                                            ->helperText('Allow tagging of blog posts'),

                                        Toggle::make('enable_reading_time')
                                            ->label('Enable Reading Time')
                                            ->helperText('Display estimated reading time'),
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
                                        TextInput::make('meta_title')
                                            ->label('Default Meta Title')
                                            ->maxLength(60)
                                            ->helperText('Default title for pages without specific SEO title'),

                                        Textarea::make('meta_description')
                                            ->label('Default Meta Description')
                                            ->maxLength(160)
                                            ->rows(3)
                                            ->helperText('Default description for pages without specific SEO description'),

                                        TagsInput::make('meta_keywords')
                                            ->label('Default Keywords')
                                            ->placeholder('Enter keywords...')
                                            ->helperText('Keywords for your site'),

                                        TextInput::make('google_site_verification')
                                            ->label('Google Site Verification')
                                            ->placeholder('google-site-verification=...')
                                            ->helperText('Google Search Console verification meta tag content'),

                                        TextInput::make('bing_site_verification')
                                            ->label('Bing Site Verification')
                                            ->placeholder('msvalidate.01=...')
                                            ->helperText('Bing Webmaster Tools verification meta tag content'),

                                        TextInput::make('google_analytics_id')
                                            ->label('Google Analytics ID')
                                            ->placeholder('GA4-XXXXXXXXXX')
                                            ->helperText('Your Google Analytics 4 measurement ID'),
                                    ])
                                    ->columns(2),

                                Section::make('Social Media & Open Graph')
                                    ->description('Social media sharing settings')
                                    ->schema([
                                        Toggle::make('enable_open_graph')
                                            ->label('Enable Open Graph')
                                            ->helperText('Enable Facebook/LinkedIn sharing cards'),

                                        Toggle::make('enable_twitter_cards')
                                            ->label('Enable Twitter Cards')
                                            ->helperText('Enable Twitter sharing cards'),

                                        Toggle::make('enable_schema_markup')
                                            ->label('Enable Schema Markup')
                                            ->helperText('Enable structured data markup'),

                                        CuratorPicker::make('og_image')
                                            ->label('Default OG Image')
                                            ->helperText('Default image for social sharing (1200x630px)')
                                            ->directory('seo')
                                            ->acceptedFileTypes(['image/jpeg', 'image/png']),

                                        TextInput::make('twitter_handle')
                                            ->label('Twitter Handle')
                                            ->placeholder('@yourhandle')
                                            ->helperText('Your Twitter handle (with @)'),
                                    ])
                                    ->columns(2),

                                Section::make('Custom Code')
                                    ->description('Custom HTML/JS code injection')
                                    ->schema([
                                        Textarea::make('custom_head_code')
                                            ->label('Custom Head Code')
                                            ->rows(5)
                                            ->helperText('Custom HTML/JS code to insert in <head>')
                                            ->columnSpanFull(),

                                        Textarea::make('custom_body_code')
                                            ->label('Custom Body Code')
                                            ->rows(5)
                                            ->helperText('Custom HTML/JS code to insert before </body>')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ])
            ->statePath('data');
    }
}
