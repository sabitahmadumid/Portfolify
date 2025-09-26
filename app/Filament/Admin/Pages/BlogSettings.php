<?php

namespace App\Filament\Admin\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Inerba\DbConfig\AbstractPageSettings;

class BlogSettings extends AbstractPageSettings
{
    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    protected static ?string $title = 'Blog Settings';

    protected static ?string $slug = 'blog-settings';

    protected string $view = 'filament.pages.blog-settings';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Blog';

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-document-text';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Settings';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    protected function settingName(): string
    {
        return 'blog';
    }

    /**
     * Provide default values.
     *
     * @return array<string, mixed>
     */
    public function getDefaultData(): array
    {
        return [
            'posts_per_page' => 10,
            'allow_comments' => true,
            'moderate_comments' => true,
            'notify_on_comment' => true,
            'comment_system' => 'built-in',
            'show_author_bio' => true,
            'show_related_posts' => true,
            'related_posts_count' => 3,
            'enable_tags' => true,
            'enable_reading_time' => true,
            'date_format' => 'M j, Y',
            'featured_posts_count' => 3,
            'show_featured_on_homepage' => true,
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Blog Settings')
                    ->schema([
                         TextInput::make('posts_per_page')
                            ->label('Posts per Page')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->maxValue(50),

                         Select::make('date_format')
                            ->label('Date Format')
                            ->options([
                                'M j, Y' => 'Jan 1, 2025',
                                'F j, Y' => 'January 1, 2025',
                                'd/m/Y' => '01/01/2025',
                                'm/d/Y' => '01/01/2025',
                                'Y-m-d' => '2025-01-01',
                            ]),
                    ]),

                Section::make('Comments')
                    ->schema([
                         Toggle::make('allow_comments')
                            ->label('Allow Comments'),

                         Toggle::make('moderate_comments')
                            ->label('Moderate Comments')
                            ->helperText('Require approval before comments are published'),

                         Toggle::make('notify_on_comment')
                            ->label('Email Notifications')
                            ->helperText('Send email notifications for new comments'),

                         Select::make('comment_system')
                            ->label('Comment System')
                            ->options([
                                'built-in' => 'Built-in Comments',
                                'disqus' => 'Disqus',
                                'none' => 'Disabled',
                            ]),
                    ]),

                Section::make('Post Display')
                    ->schema([
                         Toggle::make('show_author_bio')
                            ->label('Show Author Bio'),

                         Toggle::make('enable_reading_time')
                            ->label('Show Reading Time'),

                         Toggle::make('enable_tags')
                            ->label('Enable Tags'),

                         Toggle::make('show_related_posts')
                            ->label('Show Related Posts'),

                         TextInput::make('related_posts_count')
                            ->label('Related Posts Count')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(10),
                    ]),

              Section::make('Featured Posts')
                    ->schema([
                         Toggle::make('show_featured_on_homepage')
                            ->label('Show Featured Posts on Homepage'),

                         TextInput::make('featured_posts_count')
                            ->label('Featured Posts Count')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(10),
                    ]),
            ])
            ->statePath('data');
    }
}
