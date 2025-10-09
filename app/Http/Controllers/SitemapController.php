<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Portfolio;
use App\Models\Post;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index(): Response
    {
        if (! config('blog.sitemap.enabled')) {
            abort(404);
        }

        $sitemap = Cache::remember(
            'sitemap',
            config('blog.sitemap.cache_ttl', 86400),
            fn () => $this->generateSitemap()
        );

        return response($sitemap, 200)
            ->header('Content-Type', 'text/xml');
    }

    protected function generateSitemap(): string
    {
        $sitemap = Sitemap::create();

        // Add homepage
        $sitemap->add(
            Url::create(route('home'))
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(1.0)
        );

        // Add about page
        $sitemap->add(
            Url::create(route('about'))
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.8)
        );

        // Add contact page
        $sitemap->add(
            Url::create(route('contact'))
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.7)
        );

        // Add blog index
        if (config('blog.enabled')) {
            $sitemap->add(
                Url::create(route('blog.index'))
                    ->setLastModificationDate(now())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.9)
            );

            // Add blog categories
            Category::where('is_active', true)
                ->whereHas('posts', function ($query) {
                    $query->where('is_published', true);
                })
                ->orderBy('name')
                ->chunk(100, function ($categories) use ($sitemap) {
                    foreach ($categories as $category) {
                        $sitemap->add(
                            Url::create(route('blog.category', $category->slug))
                                ->setLastModificationDate(optional($category->updated_at)->toDateTime())
                                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                                ->setPriority(0.7)
                        );
                    }
                });

            // Add published blog posts
            Post::where('is_published', true)
                ->where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->chunk(100, function ($posts) use ($sitemap) {
                    foreach ($posts as $post) {
                        $sitemap->add(
                            Url::create(route('blog.show', $post->slug))
                                ->setLastModificationDate(optional($post->updated_at)->toDateTime())
                                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                                ->setPriority(0.8)
                        );
                    }
                });
        }

        // Add portfolio index
        $sitemap->add(
            Url::create(route('portfolio.index'))
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8)
        );

        // Add published portfolio items
        Portfolio::where('is_published', true)
            ->orderBy('sort_order')
            ->chunk(100, function ($portfolios) use ($sitemap) {
                foreach ($portfolios as $portfolio) {
                    $sitemap->add(
                        Url::create(route('portfolio.show', $portfolio->slug))
                            ->setLastModificationDate(optional($portfolio->updated_at)->toDateTime())
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                            ->setPriority(0.7)
                    );
                }
            });

        return $sitemap->render();
    }
}
