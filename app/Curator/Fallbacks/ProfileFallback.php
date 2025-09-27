<?php

namespace App\Curator\Fallbacks;

use Awcodes\Curator\Glide\GliderFallback;

class ProfileFallback extends GliderFallback
{
    public function getAlt(): string
    {
        return 'Default profile picture';
    }

    public function getHeight(): int
    {
        return 400;
    }

    public function getKey(): string
    {
        return 'profile_default';
    }

    public function getSource(): string
    {
        return asset('images/default-avatar.svg');
    }

    public function getType(): string
    {
        return 'image/svg+xml';
    }

    public function getWidth(): int
    {
        return 400;
    }
}
