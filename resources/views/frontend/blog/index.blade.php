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
                    <div class="mb-20">
                        <div class="flex items-center justify-between mb-12">
                            <h2 class="text-4xl font-bold gradient-text">Featured Articles</h2>
                            <div class="h-px bg-gradient-to-r from-blue-500 to-purple-600 flex-1 ml-8"></div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">
                            @foreach($featuredPosts as $featured)
                            <article class="group relative bg-white dark:bg-gray-900 rounded-3xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-gray-100 dark:border-gray-800 animate-fade-in-up" style="animation-delay: {{ $loop->index * 0.15 }}s">
                                <!-- Featured Badge -->
                                <div class="absolute top-4 left-4 z-10">
                                    <span class="px-3 py-1 bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs font-bold rounded-full shadow-lg flex items-center space-x-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <span>FEATURED</span>
                                    </span>
                                </div>
                                
                                <!-- Featured Image -->
                                <div class="relative overflow-hidden">
                                    @if($featured->featuredImage)
                                        <img 
                                            src="{{ Storage::disk($featured->featuredImage->disk)->url($featured->featuredImage->path) }}"
                                            class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-700"
                                            alt="{{ $featured->title }}"
                                            loading="lazy"
                                        />
                                    @else
                                        <!-- Enhanced Placeholder -->
                                        <div class="w-full h-56 bg-gradient-to-br from-blue-500 via-purple-600 to-pink-500 flex items-center justify-center relative overflow-hidden">
                                            <!-- Animated background elements -->
                                            <div class="absolute inset-0 opacity-20">
                                                <div class="absolute top-0 left-0 w-20 h-20 bg-white rounded-full -translate-x-10 -translate-y-10 group-hover:translate-x-5 group-hover:translate-y-5 transition-transform duration-1000"></div>
                                                <div class="absolute bottom-0 right-0 w-32 h-32 bg-white rounded-full translate-x-16 translate-y-16 group-hover:-translate-x-8 group-hover:-translate-y-8 transition-transform duration-1000 delay-200"></div>
                                                <div class="absolute top-1/2 left-1/2 w-16 h-16 bg-white rounded-full -translate-x-8 -translate-y-8 group-hover:translate-x-2 group-hover:translate-y-2 transition-transform duration-1000 delay-100"></div>
                                            </div>
                                            <div class="relative z-10 text-center">
                                                <svg class="w-16 h-16 text-white mb-2 mx-auto group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                                </svg>
                                                <p class="text-white text-sm font-medium opacity-90">Featured Article</p>
                                            </div>
                                        </div>
                                    @endif
                                    <!-- Gradient overlay on hover -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>
                                
                                <!-- Content -->
                                <div class="p-7">
                                    <!-- Meta Info -->
                                    <div class="flex flex-col space-y-3 mb-4">
                                        <div class="flex items-center justify-between">
                                            <span class="px-4 py-2 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/50 dark:to-purple-900/50 text-blue-800 dark:text-blue-300 text-sm font-semibold rounded-xl border border-blue-200 dark:border-blue-800 truncate max-w-[60%]">
                                                {{ $featured->category->name }}
                                            </span>
                                            <time class="text-gray-500 dark:text-gray-400 text-sm font-medium whitespace-nowrap">
                                                {{ $featured->published_at->format('M j, Y') }}
                                            </time>
                                        </div>
                                    </div>
                                    
                                    <!-- Title -->
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-3 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300 leading-tight">
                                        <a href="{{ route('blog.show', $featured->slug) }}" class="hover:underline decoration-2 underline-offset-4">
                                            {{ $featured->title }}
                                        </a>
                                    </h3>
                                    
                                    <!-- Excerpt -->
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-6 line-clamp-3 leading-relaxed">
                                        {{ $featured->excerpt }}
                                    </p>
                                    
                                    <!-- Author & Read More -->
                                    <div class="flex flex-col space-y-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                                                <span class="text-sm font-bold text-white">
                                                    {{ strtoupper(substr($featured->user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 truncate">{{ $featured->user->name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $featured->read_time ?? '5' }} min read</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('blog.show', $featured->slug) }}" 
                                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-sm font-semibold rounded-xl hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                                            <span>Read More</span>
                                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- All Posts -->
                    <div class="space-y-12">
                        @foreach($posts as $post)
                        <article class="group bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 dark:border-gray-800 transform hover:-translate-y-2 animate-fade-in-up" style="animation-delay: {{ $loop->index * 0.1 }}s">
                            <div class="flex flex-col lg:flex-row h-auto lg:h-[240px]">
                                <!-- Post Image -->
                                <div class="lg:w-72 lg:flex-shrink-0 relative overflow-hidden">
                                    <div class="aspect-video lg:aspect-auto lg:h-[240px] overflow-hidden">
                                        @if($post->featuredImage)
                                            <img 
                                                src="{{ Storage::disk($post->featuredImage->disk)->url($post->featuredImage->path) }}"
                                                class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-700"
                                                alt="{{ $post->title }}"
                                                loading="lazy"
                                            />
                                        @else
                                            <!-- Enhanced Placeholder -->
                                            <div class="w-full h-full bg-gradient-to-br from-indigo-500 via-blue-600 to-purple-700 flex items-center justify-center relative overflow-hidden">
                                                <!-- Animated background patterns -->
                                                <div class="absolute inset-0 opacity-10">
                                                    <div class="absolute top-0 left-0 w-24 h-24 bg-white rounded-full -translate-x-12 -translate-y-12 group-hover:translate-x-6 group-hover:translate-y-6 transition-transform duration-1200"></div>
                                                    <div class="absolute bottom-0 right-0 w-20 h-20 bg-white rounded-full translate-x-10 translate-y-10 group-hover:-translate-x-5 group-hover:-translate-y-5 transition-transform duration-1200 delay-300"></div>
                                                </div>
                                                <div class="relative z-10 text-center">
                                                    <svg class="w-16 h-16 text-white mb-2 mx-auto group-hover:scale-110 group-hover:rotate-3 transition-all duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    <p class="text-white text-sm font-semibold opacity-90">{{ $post->category->name }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Gradient overlay on hover -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                </div>
                                
                                <!-- Post Content -->
                                <div class="flex-1 p-4 lg:p-6 flex flex-col justify-between h-[240px]">
                                    <div class="flex-1 overflow-hidden">
                                        <!-- Meta -->
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center space-x-2">
                                                <span class="px-2.5 py-1 bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/50 dark:to-indigo-900/50 text-blue-800 dark:text-blue-300 text-xs font-semibold rounded-lg border border-blue-200 dark:border-blue-800 truncate max-w-[100px]">
                                                    {{ $post->category->name }}
                                                </span>
                                                @if($post->is_featured)
                                                <span class="px-2 py-0.5 bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs font-bold rounded-full shadow-md flex items-center space-x-1">
                                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                </span>
                                                @endif
                                            </div>
                                            <time class="text-xs text-gray-500 dark:text-gray-400 font-medium whitespace-nowrap">
                                                {{ $post->published_at->format('M j') }}
                                            </time>
                                        </div>
                                        
                                        <!-- Title -->
                                        <h2 class="text-lg lg:text-xl font-bold text-gray-900 dark:text-gray-100 mb-2 leading-tight group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300 line-clamp-2">
                                            <a href="{{ route('blog.show', $post->slug) }}" class="hover:underline decoration-2 underline-offset-4">
                                                {{ $post->title }}
                                            </a>
                                        </h2>
                                        
                                        <!-- Excerpt -->
                                        <p class="text-gray-600 dark:text-gray-400 mb-3 line-clamp-2 leading-relaxed text-sm">
                                            {{ $post->excerpt }}
                                        </p>
                                        
                                        <!-- Tags -->
                                        @if($post->tags && count($post->tags) > 0)
                                        <div class="flex flex-wrap gap-1 mb-2">
                                            @foreach(array_slice($post->tags, 0, 2) as $tag)
                                            <a href="{{ route('blog.index', ['tag' => $tag]) }}" 
                                               class="px-2 py-0.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-xs rounded-full hover:bg-blue-100 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 border border-gray-200 dark:border-gray-700">
                                                #{{ $tag }}
                                            </a>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Footer -->
                                    <div class="flex items-center justify-between pt-3 border-t border-gray-100 dark:border-gray-800 mt-auto">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow-md">
                                                <span class="text-white font-bold text-xs">
                                                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold text-gray-900 dark:text-gray-100 truncate max-w-[100px]">{{ $post->user->name }}</p>
                                                <div class="flex items-center space-x-1 text-xs text-gray-500 dark:text-gray-400">
                                                    <span>{{ $post->read_time ?? '5' }}m</span>
                                                    <span>•</span>
                                                    <span>{{ number_format($post->views_count ?? 0) }} views</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <a href="{{ route('blog.show', $post->slug) }}" 
                                           class="group inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-md hover:shadow-lg text-xs">
                                            <span>Read</span>
                                            <svg class="ml-1 w-3 h-3 group-hover:translate-x-0.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <div class="space-y-8 sticky top-8">
                        <!-- Categories -->
                        <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 shadow-lg border border-gray-100 dark:border-gray-800">
                            <div class="flex items-center space-x-2 mb-6">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Categories</h3>
                            </div>
                            <div class="space-y-3">
                                @foreach($categories as $category)
                                <a href="{{ route('blog.category', $category->slug) }}" 
                                   class="flex items-center justify-between p-3 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-blue-900/20 dark:hover:to-purple-900/20 transition-all duration-300 group border border-transparent hover:border-blue-200 dark:hover:border-blue-800">
                                    <span class="text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 font-medium">
                                        {{ $category->name }}
                                    </span>
                                    <span class="px-3 py-1 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 text-gray-600 dark:text-gray-400 text-sm rounded-full group-hover:from-blue-100 group-hover:to-purple-100 dark:group-hover:from-blue-900/50 dark:group-hover:to-purple-900/50 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-all duration-300">
                                        {{ $category->published_posts_count }}
                                    </span>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Newsletter Signup -->
                        <div class="bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden">
                            <!-- Background decoration -->
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -translate-y-16 translate-x-16"></div>
                            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white opacity-10 rounded-full translate-y-12 -translate-x-12"></div>
                            
                            <div class="relative z-10">
                                <div class="flex items-center space-x-2 mb-3">
                                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 003.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold">Stay Updated</h3>
                                </div>
                                <p class="text-blue-100 mb-6 text-sm leading-relaxed">
                                    Get the latest articles and insights delivered to your inbox. Join our growing community!
                                </p>
                                <form class="space-y-4">
                                    <div class="relative">
                                        <input type="email" 
                                               placeholder="Enter your email..."
                                               class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-xl placeholder-blue-100 text-white focus:outline-none focus:ring-2 focus:ring-white/50 focus:bg-white/30 transition-all duration-300 backdrop-blur-sm">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.11a4 4 0 10-4 4 4 4 0 004-4V12zm0 0V8a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <button type="submit" 
                                            class="w-full px-4 py-3 bg-white text-blue-600 font-bold rounded-xl hover:bg-blue-50 hover:shadow-lg transform hover:scale-105 transition-all duration-300 flex items-center justify-center space-x-2">
                                        <span>Subscribe Now</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-32">
                <div class="relative mx-auto mb-8">
                    <div class="w-32 h-32 bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 rounded-3xl flex items-center justify-center mx-auto">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <!-- Decorative elements -->
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-4 w-4 h-4 bg-blue-400 rounded-full opacity-60"></div>
                    <div class="absolute bottom-0 right-1/4 w-3 h-3 bg-purple-400 rounded-full opacity-60"></div>
                    <div class="absolute top-1/2 right-0 w-2 h-2 bg-pink-400 rounded-full opacity-60"></div>
                </div>
                
                <h3 class="text-3xl font-bold gradient-text mb-4">No Articles Found</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-8 text-lg max-w-md mx-auto leading-relaxed">
                    @if(request()->hasAny(['search', 'category', 'tag']))
                        No articles match your current search criteria. Try adjusting your filters or search terms.
                    @else
                        No articles have been published yet. Check back soon for exciting updates and insights!
                    @endif
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('blog.index') }}" class="btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset Filters
                    </a>
                    @if(!request()->hasAny(['search', 'category', 'tag']))
                    <a href="{{ route('contact') }}" class="btn-secondary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Contact Us
                    </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</section>
@endsection