<?php

declare(strict_types=1);

return [
    'curation_formats' => ['jpg', 'jpeg', 'png', 'webp', 'avif'],
    'curation_presets' => [
        App\Curator\Presets\ThumbnailPreset::class,
        App\Curator\Presets\LargePreset::class,
        App\Curator\Presets\ProfilePreset::class,
        App\Curator\Presets\LogoPreset::class,
    ],
    'default_disk' => env('CURATOR_DEFAULT_DISK', 'public'),
    'default_visibility' => 'public',
    'features' => [
        'curations' => false,
        'file_swap' => false,
        'directory_restriction' => false,
        'tenancy' => [
            'enabled' => false,
            'relationship_name' => null,
        ],
    ],
    'glide_token' => env('CURATOR_GLIDE_TOKEN', hash('sha256', config('app.key', 'fallback-key').'curator-glide')),
    'model' => \Awcodes\Curator\Models\Media::class,
    'path_generator' => null,
    'glide' => [
        'fallbacks' => [
            App\Curator\Fallbacks\DefaultFallback::class,
            App\Curator\Fallbacks\ProfileFallback::class,
        ],
    ],
    'resource' => [
        'label' => 'Media',
        'plural_label' => 'Media',
        'default_layout' => 'grid',
        'navigation' => [
            'group' => null,
            'icon' => 'heroicon-o-photo',
            'sort' => null,
            'should_register' => true,
            'should_show_badge' => false,
        ],
        'resource' => App\Filament\Resources\MediaResource::class,
        'pages' => [
            'create' => App\Filament\Resources\MediaResource\Pages\CreateMedia::class,
            'edit' => App\Filament\Resources\MediaResource\Pages\EditMedia::class,
            'index' => App\Filament\Resources\MediaResource\Pages\ListMedia::class,
        ],
        'schemas' => [
            'form' => Awcodes\Curator\Resources\Media\Schemas\MediaForm::class,
        ],
        'tables' => [
            'table' => Awcodes\Curator\Resources\Media\Tables\MediaTable::class,
        ],
    ],
    'url_provider' => Awcodes\Curator\Providers\GlideUrlProvider::class,
];
