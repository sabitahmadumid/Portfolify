<?php

namespace App\Curator\Presets;

use Awcodes\Curator\Curations\CurationPreset;

class ProfilePreset extends CurationPreset
{
    public function getKey(): string
    {
        return 'profile';
    }

    public function getLabel(): string
    {
        return 'Profile Picture';
    }

    public function getWidth(): int
    {
        return 400;
    }

    public function getHeight(): int
    {
        return 400;
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
