<?php

namespace App\Curator\Presets;

use Awcodes\Curator\Curations\CurationPreset;

class LargePreset implements CurationPreset
{
    public function getKey(): string
    {
        return 'large';
    }

    public function getLabel(): string
    {
        return 'Large';
    }

    public function getWidth(): int
    {
        return 1200;
    }

    public function getHeight(): int
    {
        return 800;
    }

    public function getFormat(): string
    {
        return 'webp';
    }

    public function getQuality(): int
    {
        return 85;
    }
}