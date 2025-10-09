<?php

use App\Models\Category;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can generate sitemap.xml', function () {
    $response = $this->get('/sitemap.xml');

    $response->assertSuccessful()
        ->assertHeader('Content-Type', 'text/xml; charset=UTF-8');

    $content = $response->getContent();
    expect($content)->toContain('<?xml version="1.0" encoding="UTF-8"?>')
        ->toContain('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"')
        ->toContain(route('home'))
        ->toContain(route('about'))
        ->toContain(route('contact'));
});

it('includes published blog posts in sitemap', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create(['is_active' => true]);

    $publishedPost = Post::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category->id,
        'is_published' => true,
        'published_at' => now()->subDay(),
    ]);

    $unpublishedPost = Post::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category->id,
        'is_published' => false,
    ]);

    $response = $this->get('/sitemap.xml');

    $response->assertSuccessful()
        ->assertSee(route('blog.show', $publishedPost->slug))
        ->assertDontSee(route('blog.show', $unpublishedPost->slug));
});

it('includes published portfolio items in sitemap', function () {
    $publishedPortfolio = Portfolio::factory()->create([
        'is_published' => true,
    ]);

    $unpublishedPortfolio = Portfolio::factory()->create([
        'is_published' => false,
    ]);

    $response = $this->get('/sitemap.xml');

    $response->assertSuccessful()
        ->assertSee(route('portfolio.show', $publishedPortfolio->slug))
        ->assertDontSee(route('portfolio.show', $unpublishedPortfolio->slug));
});

it('can generate RSS feed', function () {
    $response = $this->get('/rss.xml');

    $response->assertSuccessful()
        ->assertHeader('Content-Type', 'application/rss+xml; charset=UTF-8');

    $content = $response->getContent();
    expect($content)->toContain('<?xml version="1.0" encoding="UTF-8"?>')
        ->toContain('<rss version="2.0"')
        ->toContain('<channel>')
        ->toContain('<title><![CDATA['.config('app.name').' - Blog]]></title>');
});

it('includes published blog posts in RSS feed', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create(['is_active' => true]);

    $publishedPost = Post::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category->id,
        'is_published' => true,
        'published_at' => now()->subDay(),
        'title' => 'Published Test Post',
        'excerpt' => 'This is a test excerpt',
    ]);

    $unpublishedPost = Post::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category->id,
        'is_published' => false,
        'title' => 'Unpublished Test Post',
    ]);

    $response = $this->get('/rss.xml');

    $response->assertSuccessful();

    $content = $response->getContent();
    expect($content)->toContain('<title><![CDATA[Published Test Post]]></title>')
        ->toContain(route('blog.show', $publishedPost->slug))
        ->not->toContain('Unpublished Test Post');
});

it('returns 404 when sitemap is disabled', function () {
    config(['blog.sitemap.enabled' => false]);

    $response = $this->get('/sitemap.xml');

    $response->assertNotFound();
});

it('returns 404 when RSS is disabled', function () {
    config(['blog.rss.enabled' => false]);

    $response = $this->get('/rss.xml');

    $response->assertNotFound();
});

it('can access RSS feed via /feed route', function () {
    $response = $this->get('/feed');

    $response->assertSuccessful()
        ->assertHeader('Content-Type', 'application/rss+xml; charset=UTF-8');
});
