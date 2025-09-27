@extends('frontend.layouts.app')

@section('title', 'Blog - Insights & Stories')
@section('description', 'Discover insights, tutorials, and stories from my creative journey. Stay updated with the latest posts and trends.')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-950 dark:to-gray-900">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 right-1/4 w-64 h-64 bg-blue-200/20 dark:bg-blue-900/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 left-1/4 w-96 h-96 bg-purple-200/20 dark:bg-purple-900/10 rounded-full blur-3xl"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 dark:text-gray-100 mb-6">
                My <span class="gradient-text">Blog</span>
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto mb-8">
                Insights, tutorials, and stories from my creative journey. 
                Exploring the intersection of design, technology, and innovation.
            </p>
        </div>
        
        <!-- Search & Filters -->
        <div class="max-w-4xl mx-auto">
            <form method="GET" class="mb-8">
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Search -->
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Search articles..."
                                   class="w-full px-4 py-3 pl-12 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Category Filter -->
                    <div class="md:w-48">
                        <select name="category" 
                                onchange="this.form.submit()"
                                class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>
                                {{ $category->name }} ({{ $category->published_posts_count }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Search Button -->
                    <button type="submit" class="btn-primary md:w-auto">
                        <svg class="w-5 h-5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span class="hidden md:inline">Search</span>
                    </button>
                </div>
            </form>
            
            <!-- Active Filters -->
            @if(request()->filled('search') || request()->filled('category') || request()->filled('tag'))
            <div class="flex flex-wrap items-center gap-2 mb-8">
                <span class="text-sm text-gray-600 dark:text-gray-400">Active filters:</span>
                
                @if(request('search'))
                <div class="flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full text-sm">
                    Search: "{{ request('search') }}"
                    <a href="{{ request()->url() }}?{{ http_build_query(request()->except('search')) }}" 
                       class="ml-2 hover:text-blue-600 dark:hover:text-blue-400">×</a>
                </div>
                @endif
                
                @if(request('category'))
                <div class="flex items-center px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 rounded-full text-sm">
                    Category: {{ $categories->where('slug', request('category'))->first()->name ?? request('category') }}
                    <a href="{{ request()->url() }}?{{ http_build_query(request()->except('category')) }}" 
                       class="ml-2 hover:text-purple-600 dark:hover:text-purple-400">×</a>
                </div>
                @endif
                
                @if(request('tag'))
                <div class="flex items-center px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-full text-sm">
                    Tag: {{ request('tag') }}
                    <a href="{{ request()->url() }}?{{ http_build_query(request()->except('tag')) }}" 
                       class="ml-2 hover:text-green-600 dark:hover:text-green-400">×</a>
                </div>
                @endif
                
                <a href="{{ route('blog.index') }}" 
                   class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 underline">
                    Clear all
                </a>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-16 bg-white dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($posts->count() > 0)
            <!-- Results Info -->
            <div class="mb-8 text-center">
                <p class="text-gray-600 dark:text-gray-400">
                    Showing {{ $posts->count() }} of {{ $posts->total() }} articles
                    @if(request()->filled('search') || request()->filled('category') || request()->filled('tag'))
                        matching your criteria
                    @endif
                </p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <!-- Featured Posts (only on first page without filters) -->
                    @if($featuredPosts->count() > 0 && !request()->hasAny(['search', 'category', 'tag']) && $posts->currentPage() === 1)
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Featured Articles</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($featuredPosts as $featured)
                            <article class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden card-hover">
                                <!-- Featured Image -->
                                <div class="aspect-video overflow-hidden relative">
                                    @if($featured->featuredImage)
                                        <img 
                                            src="{{ $featured->featuredImage->url }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                            alt="{{ $featured->title }}"
                                            loading="lazy"
                                        />
                                    @else
                                        <!-- Placeholder when no featured image -->
                                        <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 002 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Featured Badge -->
                                    <div class="absolute top-3 left-3 px-2 py-1 bg-yellow-500 text-white text-xs font-semibold rounded-full">
                                        Featured
                                    </div>
                                </div>
                                
                                <!-- Content -->
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-sm rounded-full">
                                            {{ $featured->category->name }}
                                        </span>
                                        <time class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $featured->published_at->format('M d, Y') }}
                                        </time>
                                    </div>
                                    
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                        <a href="{{ route('blog.show', $featured->slug) }}">{{ $featured->title }}</a>
                                    </h3>
                                    
                                    <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2 mb-3">
                                        {{ $featured->excerpt }}
                                    </p>
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                                <span class="text-white text-xs font-semibold">
                                                    {{ substr($featured->user->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $featured->user->name }}</span>
                                        </div>
                                        
                                        <a href="{{ route('blog.show', $featured->slug) }}" 
                                           class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold text-sm transition-colors">
                                            Read →
                                        </a>
                                    </div>
                                </div>
                            </article>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- All Posts -->
                    <div class="space-y-8">
                        @foreach($posts as $post)
                        <article class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                            <div class="flex flex-col md:flex-row">
                                <!-- Post Image -->
                                <div class="md:w-1/3">
                                    <div class="aspect-video md:aspect-square overflow-hidden">
                                        @if($post->featuredImage)
                                            <img 
                                                src="{{ $post->featuredImage->url }}"
                                                class="w-full h-full object-cover hover:scale-110 transition-transform duration-500"
                                                alt="{{ $post->title }}"
                                                loading="lazy"
                                            />
                                        @else
                                            <!-- Placeholder when no featured image -->
                                            <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
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
                        <!-- Categories -->
                        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-lg">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Categories</h3>
                            <div class="space-y-2">
                                @foreach($categories as $category)
                                <a href="{{ route('blog.category', $category->slug) }}" 
                                   class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors group">
                                    <span class="text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                        {{ $category->name }}
                                    </span>
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-sm rounded">
                                        {{ $category->published_posts_count }}
                                    </span>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Newsletter Signup -->
                        <div class="bg-gradient-to-br from-blue-600 to-purple-700 rounded-2xl p-6 text-white">
                            <h3 class="text-lg font-bold mb-2">Stay Updated</h3>
                            <p class="text-blue-100 mb-4 text-sm">
                                Get the latest articles and insights delivered to your inbox.
                            </p>
                            <form class="space-y-3">
                                <input type="email" 
                                       placeholder="Your email address"
                                       class="w-full px-4 py-2 bg-white/20 border border-white/30 rounded-lg placeholder-blue-100 text-white focus:outline-none focus:ring-2 focus:ring-white/50">
                                <button type="submit" 
                                        class="w-full px-4 py-2 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition-colors">
                                    Subscribe
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">No Articles Found</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    @if(request()->hasAny(['search', 'category', 'tag']))
                        No articles match your current search criteria. Try adjusting your filters.
                    @else
                        No articles have been published yet. Check back soon for updates!
                    @endif
                </p>
                <a href="{{ route('blog.index') }}" class="btn-primary">
                    View All Articles
                </a>
            </div>
        @endif
    </div>
</section>
@endsection