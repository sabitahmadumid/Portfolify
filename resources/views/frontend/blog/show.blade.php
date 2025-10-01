@extends('frontend.layouts.app')

@section('title', $post->title)
@section('description', $post->excerpt ?: Str::limit(strip_tags($post->content), 160))

@section('content')
<!-- Article Header -->
<article class="py-12 lg:py-20">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-12 animate-fade-in-up" style="animation-delay: 0.1s">
            <ol class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                <li>
                    <a href="{{ route('home') }}" 
                       class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300 font-medium">
                        Home
                    </a>
                </li>
                <li class="before:content-['→'] before:mx-3 before:text-gray-300 dark:before:text-gray-600">
                    <a href="{{ route('blog.index') }}" 
                       class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300 font-medium">
                        Blog
                    </a>
                </li>
                @if($post->category)
                <li class="before:content-['→'] before:mx-3 before:text-gray-300 dark:before:text-gray-600">
                    <a href="{{ route('blog.category', $post->category->slug) }}" 
                       class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300 font-medium">
                        {{ $post->category->name ?? 'Uncategorized' }}
                    </a>
                </li>
                @endif
                <li class="before:content-['→'] before:mx-3 before:text-gray-300 dark:before:text-gray-600 text-gray-900 dark:text-gray-100 font-semibold truncate">
                    {{ Str::limit($post->title, 50) }}
                </li>
            </ol>
        </nav>

        <!-- Article Meta -->
        <div class="mb-12 text-center">
            <!-- Badges -->
            <div class="flex items-center justify-center space-x-3 mb-8 animate-fade-in-up" style="animation-delay: 0.2s">
                @if($post->category)
                <span class="px-4 py-2 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/50 dark:to-purple-900/50 text-blue-800 dark:text-blue-300 text-sm font-semibold rounded-xl border border-blue-200 dark:border-blue-800 shadow-sm">
                    {{ $post->category->name }}
                </span>
                @endif
                @if($post->is_featured)
                <span class="px-4 py-2 bg-gradient-to-r from-yellow-100 to-orange-100 dark:from-yellow-900/50 dark:to-orange-900/50 text-yellow-800 dark:text-yellow-300 text-sm font-semibold rounded-xl border border-yellow-200 dark:border-yellow-800 shadow-sm flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <span>Featured</span>
                </span>
                @endif
            </div>
            
            <!-- Title -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-gray-100 mb-8 leading-tight animate-fade-in-up" style="animation-delay: 0.3s">
                <span class="gradient-text-hover transition-all duration-500">
                    {{ $post->title }}
                </span>
            </h1>
            
            <!-- Excerpt -->
            @if($post->excerpt)
            <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-400 mb-10 leading-relaxed max-w-3xl mx-auto animate-fade-in-up" style="animation-delay: 0.4s">
                {{ $post->excerpt }}
            </p>
            @endif
            
            <!-- Author and Meta Info -->
            <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-8 text-sm animate-fade-in-up" style="animation-delay: 0.5s">
                <!-- Author -->
                <div class="flex items-center space-x-4 bg-white dark:bg-gray-800 px-6 py-4 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                        @if($post->user && $post->user->profile_image)
                            <img src="{{ $post->user->profile_image }}" alt="{{ $post->user->name }}" class="w-full h-full rounded-full object-cover">
                        @else
                            <span class="text-white font-bold text-lg">
                                {{ $post->user ? strtoupper(substr($post->user->name, 0, 1)) : 'A' }}
                            </span>
                        @endif
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $post->user->name ?? 'Anonymous' }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Author</p>
                    </div>
                </div>
                
                <!-- Meta Info -->
                <div class="flex items-center space-x-6 text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800/50 px-6 py-4 rounded-2xl">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0v1a2 2 0 002 2h4a2 2 0 002-2V7m-6 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2m-6 0V3a2 2 0 012-2h4a2 2 0 012 2v4"></path>
                        </svg>
                        <time datetime="{{ $post->published_at->toISOString() }}" class="font-medium">
                            {{ $post->published_at->format('M d, Y') }}
                        </time>
                    </div>
                    <span class="text-gray-300 dark:text-gray-600">•</span>
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span class="font-medium">{{ number_format($post->views_count ?? 0) }} views</span>
                    </div>
                    @if($post->reading_time)
                        <span class="text-gray-300 dark:text-gray-600">•</span>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">{{ $post->reading_time }} min read</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Featured Image -->
        @if($post->featuredImage)
        <div class="mb-16 animate-fade-in-up" style="animation-delay: 0.6s">
            <div class="aspect-video bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 dark:from-gray-800 dark:via-gray-800 dark:to-gray-700 rounded-3xl overflow-hidden shadow-2xl border border-gray-100 dark:border-gray-700 group relative">
                <img 
                    src="{{ Storage::disk($post->featuredImage->disk)->url($post->featuredImage->path) }}"
                    alt="{{ $post->title }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                    loading="eager"
                />
                <!-- Subtle overlay for better text contrast if needed -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
            </div>
        </div>
        @endif

        <!-- Article Content -->
        <div class="prose prose-xl dark:prose-invert max-w-none mb-16 animate-fade-in-up" style="animation-delay: 0.7s">
            <div class="prose-headings:gradient-text prose-headings:font-bold prose-headings:tracking-tight prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-p:leading-relaxed prose-strong:text-gray-900 dark:prose-strong:text-gray-100 prose-strong:font-semibold prose-blockquote:border-l-4 prose-blockquote:border-blue-500 prose-blockquote:bg-blue-50 dark:prose-blockquote:bg-blue-900/20 prose-blockquote:rounded-r-lg prose-blockquote:py-4 prose-code:bg-gray-100 dark:prose-code:bg-gray-800 prose-code:px-2 prose-code:py-1 prose-code:rounded prose-code:text-sm prose-pre:bg-gray-900 prose-pre:rounded-xl prose-a:text-blue-600 dark:prose-a:text-blue-400 prose-a:no-underline hover:prose-a:underline prose-a:font-medium prose-a:transition-all">
                {!! $post->content !!}
            </div>
        </div>

        <!-- Gallery Images -->
        @if(isset($post->gallery_images) && count($post->gallery_images) > 0)
        <div class="mb-12">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Gallery</h3>
            <x-image-gallery :images="$post->gallery_images" />
        </div>
        @endif

        <!-- Tags -->
        @if(isset($post->tags) && count($post->tags) > 0)
        <div class="mb-16 pt-12 border-t border-gray-200 dark:border-gray-800 animate-fade-in-up" style="animation-delay: 0.8s">
            <div class="flex items-center space-x-3 mb-6">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Related Topics</h3>
            </div>
            <div class="flex flex-wrap gap-3">
                @foreach($post->tags as $tag)
                <a href="{{ route('blog.index', ['tag' => $tag]) }}" 
                   class="group inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl hover:from-blue-100 hover:to-purple-100 dark:hover:from-blue-900/30 dark:hover:to-purple-900/30 hover:text-blue-800 dark:hover:text-blue-300 transition-all duration-300 transform hover:scale-105 border border-gray-200 dark:border-gray-600 hover:border-blue-300 dark:hover:border-blue-600 shadow-sm hover:shadow-md">
                    <span class="mr-1">#</span>{{ $tag }}
                    <svg class="ml-2 w-3 h-3 opacity-0 group-hover:opacity-100 transform translate-x-0 group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Share & Actions -->
        <div class="mb-16 pt-12 border-t border-gray-200 dark:border-gray-800 animate-fade-in-up" style="animation-delay: 0.9s">
            <div class="bg-gradient-to-r from-gray-50 to-blue-50 dark:from-gray-800 dark:to-blue-900/20 rounded-3xl p-8 border border-gray-100 dark:border-gray-700">
                <div class="flex flex-col lg:flex-row items-center justify-between space-y-6 lg:space-y-0">
                    <!-- Share Section -->
                    <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6">
                        <span class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                            </svg>
                            <span>Share this article</span>
                        </span>
                        <div class="flex items-center space-x-3">
                            <!-- Twitter -->
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(request()->url()) }}" 
                               target="_blank"
                               class="group p-3 bg-blue-500 hover:bg-blue-600 text-white rounded-xl transition-all duration-300 transform hover:scale-110 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                            <!-- LinkedIn -->
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" 
                               target="_blank"
                               class="group p-3 bg-blue-700 hover:bg-blue-800 text-white rounded-xl transition-all duration-300 transform hover:scale-110 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                            <!-- Copy Link -->
                            <button onclick="copyToClipboard('{{ request()->url() }}')" 
                                    class="group p-3 bg-gray-600 hover:bg-gray-700 text-white rounded-xl transition-all duration-300 transform hover:scale-110 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Back Button -->
                    <a href="{{ route('blog.index') }}" 
                       class="group inline-flex items-center px-6 py-3 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-semibold rounded-xl border border-gray-200 dark:border-gray-600 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300 transform hover:scale-105 shadow-sm hover:shadow-md">
                        <svg class="mr-2 w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to All Posts
                    </a>
                </div>
            </div>
        </div>
    </div>
</article>

<!-- Comments Section -->
<x-comments-section :post="$post" :comments="$comments" />

<!-- Related Posts -->
@if($relatedPosts->count() > 0)
<section class="py-20 bg-gradient-to-br from-gray-50 via-blue-50/30 to-purple-50/30 dark:from-gray-900 dark:via-blue-950/30 dark:to-purple-950/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-fade-in-up">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-gray-100 mb-6">
                <span class="gradient-text">Related</span> Articles
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Discover more insights from {{ $post->category ? 'the ' . $post->category->name . ' category' : 'our collection' }}
            </p>
        </div>
        
        <!-- Articles Grid -->
        <div class="flex justify-center mb-12">
            @php
                $gridClasses = match($relatedPosts->count()) {
                    1 => 'grid grid-cols-1 gap-8 max-w-md',
                    2 => 'grid grid-cols-1 md:grid-cols-2 gap-8 max-w-2xl',
                    default => 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl'
                };
            @endphp
            <div class="{{ $gridClasses }}">
                @foreach($relatedPosts as $related)
                <article class="group animate-fade-in-up" style="animation-delay: {{ $loop->index * 0.15 }}s">
                    <a href="{{ route('blog.show', $related->slug) }}" class="block">
                        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 dark:border-gray-700 transform hover:-translate-y-2 h-auto lg:h-[520px] flex flex-col">
                            <!-- Featured Image -->
                            <div class="h-48 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 dark:from-gray-800 dark:via-gray-800 dark:to-gray-700 overflow-hidden flex-shrink-0 relative">
                                @if($related->featuredImage)
                                    <img 
                                        src="{{ Storage::disk($related->featuredImage->disk)->url($related->featuredImage->path) }}"
                                        alt="{{ $related->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                        loading="lazy"
                                    />
                                @else
                                    <!-- Enhanced Placeholder -->
                                    <div class="w-full h-full bg-gradient-to-br from-blue-500 via-purple-600 to-pink-500 flex items-center justify-center relative overflow-hidden">
                                        <!-- Animated background elements -->
                                        <div class="absolute inset-0 opacity-20">
                                            <div class="absolute top-0 left-0 w-16 h-16 bg-white rounded-full -translate-x-8 -translate-y-8 group-hover:translate-x-2 group-hover:translate-y-2 transition-transform duration-1000"></div>
                                            <div class="absolute bottom-0 right-0 w-24 h-24 bg-white rounded-full translate-x-12 translate-y-12 group-hover:-translate-x-4 group-hover:-translate-y-4 transition-transform duration-1000 delay-200"></div>
                                        </div>
                                        <div class="relative z-10 text-center">
                                            <svg class="w-12 h-12 text-white mb-2 mx-auto group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                            </svg>
                                            <p class="text-white text-sm font-medium opacity-90">{{ $related->category->name ?? 'Article' }}</p>
                                        </div>
                                    </div>
                                @endif
                                <!-- Gradient overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-5 flex flex-col flex-grow">
                                <!-- Category Badge -->
                                @if($related->category)
                                <div class="mb-3">
                                    <span class="inline-block px-3 py-1 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/50 dark:to-purple-900/50 text-blue-800 dark:text-blue-300 text-sm font-semibold rounded-xl border border-blue-200 dark:border-blue-800">
                                        {{ $related->category->name }}
                                    </span>
                                </div>
                                @endif
                                
                                <!-- Title -->
                                <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-3 line-clamp-2 text-lg leading-tight group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">
                                    {{ $related->title }}
                                </h3>
                                
                                <!-- Excerpt -->
                                @if($related->excerpt)
                                <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2 mb-4 leading-relaxed flex-grow">
                                    {{ $related->excerpt }}
                                </p>
                                @endif
                                
                                <!-- Meta Info - Fixed at bottom -->
                                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 pt-4 border-t border-gray-100 dark:border-gray-700 mt-auto">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow-md">
                                            <span class="text-white text-xs font-bold">
                                                {{ $related->user ? strtoupper(substr($related->user->name, 0, 1)) : 'A' }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-700 dark:text-gray-300">{{ $related->user->name ?? 'Anonymous' }}</p>
                                        </div>
                                    </div>
                                    
                                    <time class="font-medium">{{ $related->published_at->format('M d, Y') }}</time>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>
                @endforeach
            </div>
        </div>
        
        <!-- View All Button -->
        @if($post->category)
        <div class="text-center animate-fade-in-up" style="animation-delay: 0.8s">
            <a href="{{ route('blog.category', $post->category->slug) }}" 
               class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-2xl hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                <span>View All {{ $post->category->name }} Posts</span>
                <svg class="ml-3 w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
        @endif
    </div>
</section>
@endif
@endsection

@push('scripts')
<script>
    window.copyToClipboard = function(text) {
        try {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(function() {
                    if (typeof showSuccessToast === 'function') {
                        showSuccessToast('Link copied to clipboard!');
                    }
                }).catch(function(err) {
                    if (typeof showErrorToast === 'function') {
                        showErrorToast('Failed to copy link to clipboard');
                    }
                    console.error('Could not copy text: ', err);
                });
            } else {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                try {
                    document.execCommand('copy');
                    if (typeof showSuccessToast === 'function') {
                        showSuccessToast('Link copied to clipboard!');
                    }
                } catch (err) {
                    if (typeof showErrorToast === 'function') {
                        showErrorToast('Failed to copy link to clipboard');
                    }
                }
                document.body.removeChild(textArea);
            }
        } catch (error) {
            console.error('Error in copyToClipboard:', error);
        }
    };
</script>
@endpush