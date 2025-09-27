<?php

namespace App\Curator\Presets;

use Awcodes\Curator\Curations\CurationPreset;

class LogoPreset extends CurationPreset
{
    public function getKey(): string
    {
        return 'logo';
    }

    public function getLabel(): string
    {
        return 'Logo';
    }

    public function getWidth(): int
    {
        return 250;
    }

    public function getHeight(): int
    {
        return 60;
    }

    public function getFormat(): string
    {
        return 'webp';
    }

    public function getQuality(): int
    {
        return 90;
    }
}
