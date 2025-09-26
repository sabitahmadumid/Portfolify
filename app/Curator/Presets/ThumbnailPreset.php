<?php

namespace App\Curator\Presets;

use Awcodes\Curator\Curations\CurationPreset;

class ThumbnailPreset implements CurationPreset
{
    public function getKey(): string
    {
        return 'thumbnail';
    }

    public function getLabel(): string
    {
        return 'Thumbnail';
    }

    public function getWidth(): int
    {
        return 400;
    }

    public function getHeight(): int
    {
        return 300;
    }

    public function getFormat(): string
    {
        return 'webp';
    }

    public function getQuality(): int
    {
        return 80;
    }
}