<?php

if (!function_exists('safe_media_url')) {
    /**
     * Get a safe URL for a media file that bypasses the problematic temporary URL generation
     */
    function safe_media_url($media): ?string
    {
        return \App\Helpers\MediaHelper::getSafeUrl($media);
    }
}