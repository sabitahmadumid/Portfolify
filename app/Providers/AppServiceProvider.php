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
        // Register observers
        ContactMessage::observe(ContactMessageObserver::class);

        // Register SEO-related observers
        \App\Models\Post::observe(\App\Observers\PostObserver::class);
        \App\Models\Portfolio::observe(\App\Observers\PortfolioObserver::class);
        \App\Models\Category::observe(\App\Observers\CategoryObserver::class);
    }
}
