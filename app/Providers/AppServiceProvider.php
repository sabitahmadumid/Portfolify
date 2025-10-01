<?php

namespace App\Providers;

use App\Models\ContactMessage;
use App\Observers\ContactMessageObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the ContactMessage observer
        ContactMessage::observe(ContactMessageObserver::class);
        
        // Register global helper function for safe media URLs
        if (!function_exists('safe_media_url')) {
            function safe_media_url($media) {
                return \App\Helpers\MediaHelper::getSafeUrl($media);
            }
        }
    }
}
