<?php

namespace App\Filament\Admin\Resources\Posts\Schemas;

use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Models\Media;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Post')
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
                                        Select::make('category_id')
                                            ->relationship('category', 'name')
                                            ->required()
                                            ->createOptionForm([
                                                TextInput::make('name')->required(),
                                                TextInput::make('slug'),
                                                Textarea::make('description'),
                                            ]),
                                        Select::make('user_id')
                                            ->relationship('user', 'name')
                                            ->required()
                                            ->default(auth()->id()),
                                    ])
                                    ->columns(2),

                                Section::make('Content')
                                    ->schema([
                                        Textarea::make('excerpt')
                                            ->rows(3)
                                            ->hint('Brief summary of the post')
                                            ->columnSpanFull(),
                                        RichEditor::make('content')
                                            ->required()
                                            ->placeholder('Start writing your post content...')
                                            ->toolbarButtons([
                                                ['bold', 'italic', 'underline', 'strike', 'link'],
                                                ['h1', 'h2', 'h3'],
                                                ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                                ['table', 'attachFiles'],
                                                ['undo', 'redo'],
                                            ])
                                            ->fileAttachmentsDisk('public')
                                            ->fileAttachmentsDirectory('attachments')
                                            ->fileAttachmentsVisibility('public')
                                            ->extraInputAttributes([
                                                'style' => 'min-height: 300px;',
                                            ])
                                            ->hintActions([
                                                Action::make('insertMedia')
                                                    ->label('Insert Media')
                                                    ->icon('heroicon-o-photo')
                                                    ->color('gray')
                                                    ->modalHeading('Select Media to Insert')
                                                    ->modalWidth('4xl')
                                                    ->form([
                                                        CuratorPicker::make('selected_media')
                                                            ->label('Choose Media')
                                                            ->multiple()
                                                            ->buttonLabel('Select Media Files'),
                                                    ])
                                                    ->action(function (array $data, $component, $set, $get) {
                                                        if (empty($data['selected_media'])) {
                                                            return;
                                                        }

                                                        $currentContent = $get('content') ?? '';
                                                        $mediaItems = Media::whereIn('id', $data['selected_media'])->get();
                                                        $mediaHtml = '';

                                                        foreach ($mediaItems as $media) {
                                                            $url = $media->url;
                                                            $alt = $media->alt ?? $media->name;

                                                            if (str_starts_with($media->type, 'image/')) {
                                                                $mediaHtml .= "<figure><img src=\"{$url}\" alt=\"{$alt}\" style=\"max-width: 100%; height: auto; border-radius: 0.5rem;\"><figcaption style=\"text-align: center; font-style: italic; color: #666; margin-top: 0.5rem;\">{$alt}</figcaption></figure>";
                                                            } else {
                                                                $mediaHtml .= "<p><a href=\"{$url}\" target=\"_blank\" style=\"color: #3b82f6; text-decoration: underline;\">📎 {$media->name}</a></p>";
                                                            }
                                                        }

                                                        $set('content', $currentContent.$mediaHtml);
                                                    }),
                                                Action::make('insertTable')
                                                    ->label('Enhanced Table')
                                                    ->icon('heroicon-o-table-cells')
                                                    ->color('gray')
                                                    ->form([
                                                        \Filament\Forms\Components\TextInput::make('rows')
                                                            ->label('Rows')
                                                            ->numeric()
                                                            ->default(3)
                                                            ->required()
                                                            ->minValue(1)
                                                            ->maxValue(20),
                                                        \Filament\Forms\Components\TextInput::make('cols')
                                                            ->label('Columns')
                                                            ->numeric()
                                                            ->default(3)
                                                            ->required()
                                                            ->minValue(1)
                                                            ->maxValue(10),
                                                        \Filament\Forms\Components\Toggle::make('header')
                                                            ->label('Include header row')
                                                            ->default(true),
                                                        \Filament\Forms\Components\TextInput::make('caption')
                                                            ->label('Table Caption (optional)')
                                                            ->placeholder('Describe what this table shows'),
                                                    ])
                                                    ->action(function (array $data, $component, $set, $get) {
                                                        $rows = (int) $data['rows'];
                                                        $cols = (int) $data['cols'];
                                                        $hasHeader = $data['header'] ?? false;
                                                        $caption = $data['caption'] ?? '';

                                                        $currentContent = $get('content') ?? '';

                                                        $table = '<div style="margin: 1.5rem 0;">';
                                                        if ($caption) {
                                                            $table .= "<p style=\"font-weight: bold; margin-bottom: 0.5rem;\">{$caption}</p>";
                                                        }

                                                        $table .= '<table style="width: 100%; border-collapse: collapse; border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden;">';

                                                        for ($i = 0; $i < $rows; $i++) {
                                                            $table .= '<tr>';
                                                            $cellTag = ($i === 0 && $hasHeader) ? 'th' : 'td';
                                                            $cellStyle = ($i === 0 && $hasHeader)
                                                                ? 'style="border: 1px solid #e5e7eb; padding: 0.75rem; background-color: #f9fafb; font-weight: 600; text-align: left;"'
                                                                : 'style="border: 1px solid #e5e7eb; padding: 0.75rem;"';

                                                            for ($j = 0; $j < $cols; $j++) {
                                                                $placeholder = ($i === 0 && $hasHeader) ? 'Header '.($j + 1) : 'Cell content';
                                                                $table .= "<{$cellTag} {$cellStyle}>{$placeholder}</{$cellTag}>";
                                                            }
                                                            $table .= '</tr>';
                                                        }

                                                        $table .= '</table></div>';

                                                        $set('content', $currentContent.$table);
                                                    }),
                                            ])
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tabs\Tab::make('Media')
                            ->schema([
                                Section::make('Featured Image')
                                    ->schema([
                                        CuratorPicker::make('featured_image_id')
                                            ->label('Featured Image')
                                            ->buttonLabel('Select Featured Image')
                                            ->size('lg')
                                            ->relationship('featuredImage', 'id')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Gallery')
                                    ->schema([
                                        CuratorPicker::make('gallery_images')
                                            ->label('Gallery Images')
                                            ->buttonLabel('Select Gallery Images')
                                            ->multiple()
                                            ->size('lg')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tabs\Tab::make('Settings')
                            ->schema([
                                Section::make('Publishing')
                                    ->schema([
                                        Toggle::make('is_published')
                                            ->label('Published')
                                            ->default(false),
                                        Toggle::make('is_featured')
                                            ->label('Featured')
                                            ->default(false),
                                        Toggle::make('allow_comments')
                                            ->label('Allow Comments')
                                            ->default(true),
                                        DateTimePicker::make('published_at')
                                            ->label('Publish Date')
                                            ->default(now()),
                                    ])
                                    ->columns(2),

                                Section::make('Metadata')
                                    ->schema([
                                        TagsInput::make('tags')
                                            ->placeholder('Add tags')
                                            ->columnSpanFull(),
                                        TextInput::make('reading_time')
                                            ->label('Reading Time (minutes)')
                                            ->numeric()
                                            ->hint('Auto-calculated if left empty'),
                                    ]),
                            ]),

                        Tabs\Tab::make('SEO')
                            ->schema([
                                Section::make('Meta Data')
                                    ->schema([
                                        TextInput::make('meta_title')
                                            ->label('Meta Title')
                                            ->placeholder('Leave empty to use post title'),
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
