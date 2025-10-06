<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Portfolio;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        // Cache homepage data for 15 minutes
        $data = cache()->remember('homepage.data', 900, function () {
            $featuredProjects = Portfolio::published()
                ->featured()

                ->select(['id', 'title', 'slug', 'description', 'featured_image_id', 'created_at'])
                ->latest()
                ->take(3)
                ->get();

            $recentPosts = Post::published()
                ->with(['category:id,name,slug', 'user:id,name', 'featuredImage'])
                ->select(['id', 'title', 'slug', 'excerpt', 'category_id', 'user_id', 'featured_image_id', 'published_at'])
                ->latest('published_at')
                ->take(3)
                ->get();

            $categories = Category::active()
                ->select(['id', 'name', 'slug', 'color', 'icon'])
                ->orderBy('sort_order')
                ->get();

            return compact('featuredProjects', 'recentPosts', 'categories');
        });

        return view('frontend.home', $data);
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function contact()
    {
        return view('frontend.contact');
    }
}
