<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class RSSController extends Controller
{
    public function index(): Response
    {
        if (! config('blog.rss.enabled')) {
            abort(404);
        }

        $rss = Cache::remember(
            'rss_feed',
            config('blog.rss.cache_ttl', 3600),
            fn () => $this->generateRSS()
        );

        return response($rss, 200)
            ->header('Content-Type', 'application/rss+xml; charset=UTF-8');
    }

    protected function generateRSS(): string
    {
        $posts = Post::with(['user', 'category'])
            ->where('is_published', true)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(config('blog.rss.posts_count', 20))
            ->get();

        $siteUrl = config('app.url');
        $siteName = config('app.name');
        $siteDescription = 'Latest blog posts from '.$siteName;

        $lastBuildDate = $posts->first()?->published_at?->toRSSString() ?? now()->toRSSString();

        $rss = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $rss .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:content="http://purl.org/rss/1.0/modules/content/">'."\n";
        $rss .= '<channel>'."\n";
        $rss .= '<title><![CDATA['.$siteName.' - Blog]]></title>'."\n";
        $rss .= '<link>'.$siteUrl.'</link>'."\n";
        $rss .= '<description><![CDATA['.$siteDescription.']]></description>'."\n";
        $rss .= '<language>en-us</language>'."\n";
        $rss .= '<lastBuildDate>'.$lastBuildDate.'</lastBuildDate>'."\n";
        $rss .= '<atom:link href="'.route('rss').'" rel="self" type="application/rss+xml" />'."\n";
        $rss .= '<generator>Laravel '.app()->version().'</generator>'."\n";

        foreach ($posts as $post) {
            $rss .= '<item>'."\n";
            $rss .= '<title><![CDATA['.$post->title.']]></title>'."\n";
            $rss .= '<link>'.route('blog.show', $post->slug).'</link>'."\n";
            $rss .= '<guid isPermaLink="true">'.route('blog.show', $post->slug).'</guid>'."\n";
            $rss .= '<description><![CDATA['.($post->excerpt ?: strip_tags($post->content)).']]></description>'."\n";

            if ($post->content) {
                $rss .= '<content:encoded><![CDATA['.$post->content.']]></content:encoded>'."\n";
            }

            $rss .= '<pubDate>'.$post->published_at->toRSSString().'</pubDate>'."\n";

            if ($post->user) {
                $rss .= '<author><![CDATA['.$post->user->name.']]></author>'."\n";
            }

            if ($post->category) {
                $rss .= '<category><![CDATA['.$post->category->name.']]></category>'."\n";
            }

            $rss .= '</item>'."\n";
        }

        $rss .= '</channel>'."\n";
        $rss .= '</rss>';

        return $rss;
    }
}
