<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::published()
            ->with(['user:id,name', 'category:id,name,slug', 'featuredImage'])
            ->select(['id', 'title', 'slug', 'excerpt', 'user_id', 'category_id', 'featured_image_id', 'published_at', 'views_count', 'reading_time'])
            ->latest('published_at');

        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->firstOrFail(['id']);
            $query->where('category_id', $category->id);
        }

        if ($request->filled('tag')) {
            $query->whereJsonContains('tags', $request->tag);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereFullText(['title', 'excerpt', 'content'], $search)
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(config('blog.posts_per_page', 10));

        // Cache categories and featured posts separately
        $categories = cache()->remember('blog.categories', 3600, function () {
            return Category::active()
                ->withCount('publishedPosts')
                ->orderBy('sort_order')
                ->get(['id', 'name', 'slug', 'color']);
        });

        $featuredPosts = cache()->remember('blog.featured_posts', 600, function () {
            return Post::published()
                ->featured()
                ->with(['category:id,name,slug', 'user:id,name', 'featuredImage'])
                ->select(['id', 'title', 'slug', 'excerpt', 'category_id', 'user_id', 'featured_image_id', 'published_at'])
                ->latest('published_at')
                ->take(config('blog.featured_posts_count', 3))
                ->get();
        });

        return view('frontend.blog.index', compact('posts', 'categories', 'featuredPosts'));
    }

    public function show(Post $post)
    {
        if (! $post->is_published) {
            abort(404);
        }

        // Load all necessary relationships at once
        $post->load(['featuredImage', 'user:id,name', 'category:id,name,slug']);

        // Increment view count asynchronously to avoid blocking
        dispatch(function () use ($post) {
            $post->incrementViews();
        })->afterResponse();

        // Cache comments for 10 minutes
        $comments = cache()->remember("post.{$post->id}.comments", 600, function () use ($post) {
            return $post->approvedComments()
                ->parents()
                ->with([
                    'user:id,name',
                    'approvedReplies' => function ($query) {
                        $query->with([
                            'user:id,name',
                            'approvedReplies' => function ($subQuery) {
                                $subQuery->with('user:id,name');
                            },
                        ]);
                    },
                ])
                ->latest()
                ->get();
        });

        // Cache related posts for 30 minutes
        $relatedPosts = cache()->remember("post.{$post->id}.related", 1800, function () use ($post) {
            return Post::published()
                ->where('category_id', $post->category_id)
                ->where('id', '!=', $post->id)
                ->with(['category:id,name,slug'])
                ->select(['id', 'title', 'slug', 'excerpt', 'category_id', 'featured_image_id', 'published_at'])
                ->latest('published_at')
                ->take(3)
                ->get();
        });

        return view('frontend.blog.show', compact('post', 'relatedPosts', 'comments'));
    }

    public function category(Category $category)
    {
        $posts = $category->publishedPosts()
            ->with(['user', 'category', 'featuredImage'])
            ->latest('published_at')
            ->paginate(db_config('blog.posts_per_page', 10));

        $categories = Category::active()->withCount('publishedPosts')->get();

        return view('frontend.blog.category', compact('category', 'posts', 'categories'));
    }
}
