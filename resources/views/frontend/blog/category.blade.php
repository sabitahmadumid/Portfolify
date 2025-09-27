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
                    <div class="space-y-12">
                        @foreach($posts as $post)
                        <article class="group bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 dark:border-gray-800 transform hover:-translate-y-2 animate-fade-in-up" style="animation-delay: {{ $loop->index * 0.1 }}s">
                            <div class="flex flex-col lg:flex-row h-auto lg:h-[240px]">
                                <!-- Post Image -->
                                <div class="lg:w-72 lg:flex-shrink-0 relative overflow-hidden">
                                    <div class="aspect-video lg:aspect-auto lg:h-[240px] overflow-hidden">
                                        @if($post->featuredImage)
                                            <img 
                                                src="{{ $post->featuredImage->url }}"
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
                        <!-- Back to All Posts -->
                        <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 shadow-lg text-center border border-gray-100 dark:border-gray-800">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0l-4-4m4 4l-4 4"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-3">Browse All Posts</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6 text-sm leading-relaxed">
                                Explore articles from all categories and discover more content
                            </p>
                            <a href="{{ route('blog.index') }}" class="btn-primary w-full">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View All Posts
                            </a>
                        </div>
                        
                        <!-- Other Categories -->
                        @if($categories->count() > 1)
                        <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 shadow-lg border border-gray-100 dark:border-gray-800">
                            <div class="flex items-center space-x-2 mb-6">
                                <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Other Categories</h3>
                            </div>
                            <div class="space-y-3">
                                @foreach($categories->where('id', '!=', $category->id) as $otherCategory)
                                <a href="{{ route('blog.category', $otherCategory->slug) }}" 
                                   class="flex items-center justify-between p-3 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-blue-900/20 dark:hover:to-purple-900/20 transition-all duration-300 group border border-transparent hover:border-blue-200 dark:hover:border-blue-800">
                                    <span class="text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 font-medium">
                                        {{ $otherCategory->name }}
                                    </span>
                                    <span class="px-3 py-1 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 text-gray-600 dark:text-gray-400 text-sm rounded-full group-hover:from-blue-100 group-hover:to-purple-100 dark:group-hover:from-blue-900/50 dark:group-hover:to-purple-900/50 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-all duration-300">
                                        {{ $otherCategory->published_posts_count }}
                                    </span>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
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
                                    Get the latest <strong>{{ $category->name }}</strong> articles and insights delivered to your inbox!
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
                    No articles have been published in the <strong>{{ $category->name }}</strong> category yet. Check back soon for updates!
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('blog.index') }}" class="btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View All Articles
                    </a>
                    <a href="{{ route('contact') }}" class="btn-secondary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Contact Us
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection