@extends('frontend.layouts.app')

@section('title', $post->title)
@section('description', $post->excerpt ?: Str::limit(strip_tags($post->content), 160))

@section('content')
<!-- Article Header -->
<article class="py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-gray-700 dark:hover:text-gray-300">Home</a></li>
                <li class="before:content-['/'] before:mx-2">
                    <a href="{{ route('blog.index') }}" class="hover:text-gray-700 dark:hover:text-gray-300">Blog</a>
                </li>
                @if($post->category)
                <li class="before:content-['/'] before:mx-2">
                    <a href="{{ route('blog.category', $post->category->slug) }}" class="hover:text-gray-700 dark:hover:text-gray-300">
                        {{ $post->category->name ?? 'Uncategorized' }}
                    </a>
                </li>
                @endif
                <li class="before:content-['/'] before:mx-2 text-gray-900 dark:text-gray-100">{{ $post->title }}</li>
            </ol>
        </nav>

        <!-- Article Meta -->
        <div class="mb-8 text-center">
            <div class="flex items-center justify-center space-x-4 mb-4">
                @if($post->category)
                <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-sm rounded-full">
                    {{ $post->category->name }}
                </span>
                @endif
                @if($post->is_featured)
                <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 text-sm rounded-full">
                    Featured
                </span>
                @endif
            </div>
            
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-gray-100 mb-6 leading-tight">
                {{ $post->title }}
            </h1>
            
            @if($post->excerpt)
            <p class="text-xl text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                {{ $post->excerpt }}
            </p>
            @endif
            
            <!-- Author and Date -->
            <div class="flex items-center justify-center space-x-6 text-sm text-gray-500 dark:text-gray-400">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                        @if($post->user && $post->user->profile_image)
                            <img src="{{ $post->user->profile_image }}" alt="{{ $post->user->name }}" class="w-full h-full rounded-full object-cover">
                        @else
                            <span class="text-white font-semibold">
                                {{ $post->user ? substr($post->user->name, 0, 1) : 'A' }}
                            </span>
                        @endif
                    </div>
                    <div class="text-left">
                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $post->user->name ?? 'Anonymous' }}</p>
                        <p class="text-xs">Author</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <time datetime="{{ $post->published_at->toISOString() }}">
                        {{ $post->published_at->format('M d, Y') }}
                    </time>
                    <span>•</span>
                    <span>{{ number_format($post->views_count ?? 0) }} views</span>
                    @if($post->reading_time)
                        <span>•</span>
                        <span>{{ $post->reading_time }} min read</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Featured Image -->
        @if($post->featuredImage)
        <div class="mb-12">
            <div class="aspect-video bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-2xl overflow-hidden shadow-lg">
                <img 
                    src="{{ $post->featuredImage->url }}"
                    alt="{{ $post->title }}"
                    class="w-full h-full object-cover"
                    loading="eager"
                />
            </div>
        </div>
        @endif

        <!-- Article Content -->
        <div class="prose prose-lg dark:prose-invert max-w-none mb-12">
            {!! $post->content !!}
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
        <div class="mb-12 pt-8 border-t border-gray-200 dark:border-gray-800">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Tags</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($post->tags as $tag)
                <a href="{{ route('blog.index', ['tag' => $tag]) }}" 
                   class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-sm rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    #{{ $tag }}
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Share & Actions -->
        <div class="mb-12 pt-8 border-t border-gray-200 dark:border-gray-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Share this article:</span>
                    <div class="flex items-center space-x-2">
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(request()->url()) }}" 
                           target="_blank"
                           class="p-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" 
                           target="_blank"
                           class="p-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <button onclick="copyToClipboard('{{ request()->url() }}')" 
                                class="p-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <a href="{{ route('blog.index') }}" 
                   class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium transition-colors">
                    ← Back to Blog
                </a>
            </div>
        </div>
    </div>
</article>

<!-- Comments Section -->
<x-comments-section :post="$post" :comments="$comments" />

<!-- Related Posts -->
@if($relatedPosts->count() > 0)
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                Related Articles
            </h2>
            <p class="text-gray-600 dark:text-gray-400">
                More posts from the {{ $post->category->name ?? 'same' }} category
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
                <article class="group">
                    <a href="{{ route('blog.show', $related->slug) }}" class="block">
                        <div class="bg-white dark:bg-gray-950 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-800">
                            <!-- Featured Image -->
                            <div class="aspect-[16/10] bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 overflow-hidden">
                                @if($related->featuredImage)
                                    <img 
                                        src="{{ $related->featuredImage->url }}"
                                        alt="{{ $related->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                        loading="lazy"
                                    />
                                @else
                                    <!-- Placeholder when no featured image -->
                                    <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 002 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div class="p-5">
                                <!-- Category Badge -->
                                @if($related->category)
                                <div class="mb-3">
                                    <span class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-sm rounded-full font-medium">
                                        {{ $related->category->name }}
                                    </span>
                                </div>
                                @endif
                                
                                <!-- Title -->
                                <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-3 line-clamp-2 text-lg leading-6 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                    {{ $related->title }}
                                </h3>
                                
                                <!-- Excerpt -->
                                @if($related->excerpt)
                                <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-3 mb-4 leading-5">
                                    {{ $related->excerpt }}
                                </p>
                                @endif
                                
                                <!-- Meta Info -->
                                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                            <span class="text-white text-xs font-semibold">
                                                {{ $related->user ? substr($related->user->name, 0, 1) : 'A' }}
                                            </span>
                                        </div>
                                        <span>{{ $related->user->name ?? 'Anonymous' }}</span>
                                    </div>
                                    
                                    <time>{{ $related->published_at->format('M d, Y') }}</time>
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
        <div class="text-center">
            <a href="{{ route('blog.category', $post->category->slug) }}" class="btn-secondary">
                View All {{ $post->category->name }} Posts
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