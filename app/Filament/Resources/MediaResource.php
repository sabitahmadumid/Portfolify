<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaResource\Pages;
use App\Models\Media;
use Awcodes\Curator\Resources\Media\MediaResource as BaseMediaResource;

class MediaResource extends BaseMediaResource
{
    protected static ?string $model = Media::class;

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'edit' => Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}
