@extends('frontend.layouts.app')

@section('title', $category->name . ' - Blog Category')
@section('description', 'Browse all articles in the ' . $category->name . ' category. Discover insights, tutorials, and stories.')

@section('content')
<!-- Category Header -->
<section class="relative py-20 bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-950 dark:to-gray-900">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 right-1/4 w-64 h-64 bg-blue-200/20 dark:bg-blue-900/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 left-1/4 w-96 h-96 bg-purple-200/20 dark:bg-purple-900/10 rounded-full blur-3xl"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-gray-700 dark:hover:text-gray-300">Home</a></li>
                <li class="before:content-['/'] before:mx-2">
                    <a href="{{ route('blog.index') }}" class="hover:text-gray-700 dark:hover:text-gray-300">Blog</a>
                </li>
                <li class="before:content-['/'] before:mx-2 text-gray-900 dark:text-gray-100">{{ $category->name }}</li>
            </ol>
        </nav>
        
        <!-- Header -->
        <div class="text-center">
            <div class="inline-flex items-center px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full text-sm font-medium mb-6">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                Category
            </div>
            
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 dark:text-gray-100 mb-6">
                {{ $category->name }}
            </h1>
            
            @if($category->description)
            <p class="text-xl text-gray-600 dark:text-gray-400 mb-8 max-w-3xl mx-auto">
                {{ $category->description }}
            </p>
            @endif
            
            <div class="flex items-center justify-center space-x-6 text-sm text-gray-500 dark:text-gray-400">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>{{ $posts->total() }} {{ Str::plural('article', $posts->total()) }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-16 bg-white dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($posts->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <!-- Results Info -->
                    <div class="mb-8">
                        <p class="text-gray-600 dark:text-gray-400">
                            Showing {{ $posts->count() }} of {{ $posts->total() }} articles in {{ $category->name }}
                        </p>
                    </div>
                    
                    <!-- Posts -->
                    <div class="space-y-8">
                        @foreach($posts as $post)
                        <article class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                            <div class="flex flex-col md:flex-row">
                                <!-- Post Image -->
                                <div class="md:w-1/3">
                                    <div class="aspect-video md:aspect-square overflow-hidden">
                                        <x-curator-image 
                                            :media="$post"
                                            class="w-full h-full object-cover hover:scale-110 transition-transform duration-500"
                                            :alt="$post->title"
                                        />
                                    </div>
                                </div>
                                
                                <!-- Post Content -->
                                <div class="md:w-2/3 p-6">
                                    <!-- Meta -->
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-sm rounded-full">
                                                {{ $post->category->name }}
                                            </span>
                                            @if($post->is_featured)
                                            <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 text-sm rounded-full">
                                                Featured
                                            </span>
                                            @endif
                                        </div>
                                        <time class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $post->published_at->format('M d, Y') }}
                                        </time>
                                    </div>
                                    
                                    <!-- Title -->
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-3 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                    </h2>
                                    
                                    <!-- Excerpt -->
                                    <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                                        {{ $post->excerpt }}
                                    </p>
                                    
                                    <!-- Tags -->
                                    @if($post->tags && count($post->tags) > 0)
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach(array_slice($post->tags, 0, 3) as $tag)
                                        <a href="{{ route('blog.index', ['tag' => $tag]) }}" 
                                           class="px-2 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-sm rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                            #{{ $tag }}
                                        </a>
                                        @endforeach
                                    </div>
                                    @endif
                                    
                                    <!-- Footer -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                                <span class="text-white text-sm font-semibold">
                                                    {{ substr($post->user->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $post->user->name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ number_format($post->views_count ?? 0) }} views</p>
                                            </div>
                                        </div>
                                        
                                        <a href="{{ route('blog.show', $post->slug) }}" 
                                           class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold transition-colors">
                                            Read More
                                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    @if($posts->hasPages())
                    <div class="mt-12">
                        {{ $posts->links() }}
                    </div>
                    @endif
                </div>
                
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="space-y-8">
                        <!-- Back to All Posts -->
                        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-lg text-center">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Browse All Posts</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">
                                Explore articles from all categories
                            </p>
                            <a href="{{ route('blog.index') }}" class="btn-primary w-full">
                                View All Posts
                            </a>
                        </div>
                        
                        <!-- Other Categories -->
                        @if($categories->count() > 1)
                        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-lg">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Other Categories</h3>
                            <div class="space-y-2">
                                @foreach($categories->where('id', '!=', $category->id) as $otherCategory)
                                <a href="{{ route('blog.category', $otherCategory->slug) }}" 
                                   class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors group">
                                    <span class="text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                        {{ $otherCategory->name }}
                                    </span>
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-sm rounded">
                                        {{ $otherCategory->published_posts_count }}
                                    </span>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        <!-- Newsletter Signup -->
                        <div class="bg-gradient-to-br from-blue-600 to-purple-700 rounded-2xl p-6 text-white">
                            <h3 class="text-lg font-bold mb-2">Stay Updated</h3>
                            <p class="text-blue-100 mb-4 text-sm">
                                Get the latest {{ $category->name }} articles delivered to your inbox.
                            </p>
                            <form class="space-y-3">
                                <input type="email" 
                                       placeholder="Your email address"
                                       class="w-full px-4 py-2 bg-white/20 border border-white/30 rounded-lg placeholder-blue-100 text-white focus:outline-none focus:ring-2 focus:ring-white/50">
                                <button type="submit" 
                                        class="w-full bg-white text-blue-600 font-semibold py-2 px-4 rounded-lg hover:bg-blue-50 transition-colors">
                                    Subscribe
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">No Articles Yet</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">
                    There are no published articles in the {{ $category->name }} category yet. Check back later for new content.
                </p>
                <a href="{{ route('blog.index') }}" class="btn-primary">
                    Browse All Posts
                </a>
            </div>
        @endif
    </div>
</section>
@endsection