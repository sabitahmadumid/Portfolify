<?php

namespace App\Curator\Fallbacks;

use Awcodes\Curator\Glide\GliderFallback;

class DefaultFallback extends GliderFallback
{
    public function getAlt(): string
    {
        return 'Default image placeholder';
    }

    public function getHeight(): int
    {
        return 400;
    }

    public function getKey(): string
    {
        return 'default';
    }

    public function getSource(): string
    {
        return asset('images/placeholder.svg');
    }

    public function getType(): string
    {
        return 'image/svg+xml';
    }

    public function getWidth(): int
    {
        return 600;
    }
}
