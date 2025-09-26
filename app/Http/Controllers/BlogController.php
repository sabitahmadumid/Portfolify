<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::published()->with(['user', 'category'])->latest('published_at');
        
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->firstOrFail();
            $query->where('category_id', $category->id);
        }
        
        if ($request->filled('tag')) {
            $query->whereJsonContains('tags', $request->tag);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
        
        $posts = $query->with('featuredImage')->paginate(db_config('blog.posts_per_page', 10));
        $categories = Category::active()->withCount('publishedPosts')->get();
        $featuredPosts = Post::published()->featured()->with('featuredImage')->latest('published_at')->take(db_config('blog.featured_posts_count', 3))->get();
        
        return view('frontend.blog.index', compact('posts', 'categories', 'featuredPosts'));
    }
    
    public function show(Post $post)
    {
        if (!$post->is_published) {
            abort(404);
        }
        
        // Load the featured image relationship
        $post->load('featuredImage');
        
        // Increment view count
        $post->incrementViews();
        
        // Get approved comments with nested replies (recursive loading)
        $comments = $post->approvedComments()
            ->parents()
            ->with(['approvedReplies' => function($query) {
                $query->with(['approvedReplies' => function($subQuery) {
                    $subQuery->with('approvedReplies');
                }]);
            }])
            ->latest()
            ->get();
        
        // Get related posts
        $relatedPosts = Post::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->with('featuredImage')
            ->latest('published_at')
            ->take(3)
            ->get();
        
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
