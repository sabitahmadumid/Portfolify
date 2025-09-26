<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProjects = Portfolio::published()->featured()->latest()->take(3)->get();
        $recentPosts = Post::published()->latest()->take(3)->get();
        $categories = Category::active()->orderBy('sort_order')->get();
        
        return view('frontend.home', compact('featuredProjects', 'recentPosts', 'categories'));
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
