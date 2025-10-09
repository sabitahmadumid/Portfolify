<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Portfolio;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate 
                            {--force : Force regeneration even if cache exists}
                            {--file : Generate sitemap.xml file in public directory}';

    protected $description = 'Generate the sitemap for the website';

    public function handle(): int
    {
        if (! config('blog.sitemap.enabled')) {
            $this->error('Sitemap generation is disabled in configuration.');

            return Command::FAILURE;
        }

        $this->info('Generating sitemap...');

        if ($this->option('force')) {
            Cache::forget('sitemap');
            $this->info('Sitemap cache cleared.');
        }

        $sitemap = $this->generateSitemap();

        if ($this->option('file')) {
            $filePath = public_path('sitemap.xml');
            File::put($filePath, $sitemap);
            $this->info("Sitemap generated and saved to: {$filePath}");
        } else {
            Cache::put('sitemap', $sitemap, config('blog.sitemap.cache_ttl', 86400));
            $this->info('Sitemap generated and cached.');
        }

        $this->displayStats();

        return Command::SUCCESS;
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

        // Add static pages
        $sitemap->add(
            Url::create(route('about'))
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.8)
        );

        $sitemap->add(
            Url::create(route('contact'))
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.7)
        );

        // Add blog pages
        if (config('blog.enabled')) {
            $sitemap->add(
                Url::create(route('blog.index'))
                    ->setLastModificationDate(now())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.9)
            );

            $this->addBlogCategories($sitemap);
            $this->addBlogPosts($sitemap);
        }

        // Add portfolio pages
        $sitemap->add(
            Url::create(route('portfolio.index'))
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8)
        );

        $this->addPortfolioItems($sitemap);

        return $sitemap->render();
    }

    protected function addBlogCategories(Sitemap $sitemap): void
    {
        $categories = Category::where('is_active', true)
            ->whereHas('posts', function ($query) {
                $query->where('is_published', true);
            })
            ->get();

        foreach ($categories as $category) {
            $sitemap->add(
                Url::create(route('blog.category', $category->slug))
                    ->setLastModificationDate(optional($category->updated_at)->toDateTime())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.7)
            );
        }

        $this->info("Added {$categories->count()} blog categories to sitemap.");
    }

    protected function addBlogPosts(Sitemap $sitemap): void
    {
        $posts = Post::where('is_published', true)
            ->where('published_at', '<=', now())
            ->get();

        foreach ($posts as $post) {
            $sitemap->add(
                Url::create(route('blog.show', $post->slug))
                    ->setLastModificationDate(optional($post->updated_at)->toDateTime())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.8)
            );
        }

        $this->info("Added {$posts->count()} blog posts to sitemap.");
    }

    protected function addPortfolioItems(Sitemap $sitemap): void
    {
        $portfolios = Portfolio::where('is_published', true)->get();

        foreach ($portfolios as $portfolio) {
            $sitemap->add(
                Url::create(route('portfolio.show', $portfolio->slug))
                    ->setLastModificationDate(optional($portfolio->updated_at)->toDateTime())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.7)
            );
        }

        $this->info("Added {$portfolios->count()} portfolio items to sitemap.");
    }

    protected function displayStats(): void
    {
        $blogPostsCount = Post::where('is_published', true)
            ->where('published_at', '<=', now())
            ->count();

        $categoriesCount = Category::where('is_active', true)
            ->whereHas('posts', function ($query) {
                $query->where('is_published', true);
            })
            ->count();

        $portfoliosCount = Portfolio::where('is_published', true)->count();

        $this->table(
            ['Content Type', 'Count'],
            [
                ['Static Pages', '3 (Home, About, Contact)'],
                ['Blog Index', '1'],
                ['Blog Categories', $categoriesCount],
                ['Blog Posts', $blogPostsCount],
                ['Portfolio Index', '1'],
                ['Portfolio Items', $portfoliosCount],
                ['Total URLs', 5 + $categoriesCount + $blogPostsCount + $portfoliosCount],
            ]
        );
    }
}
