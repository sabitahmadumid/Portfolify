@extends('frontend.layouts.app')

@section('title', 'Portfolify - Modern Portfolio & Blog')
@section('description', 'Welcome to my creative portfolio. Discover my latest projects, insights, and creative journey.')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background with gradient -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-950 dark:to-gray-900"></div>
    
    <!-- Floating elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-blue-200/30 dark:bg-blue-900/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-3/4 right-1/4 w-96 h-96 bg-purple-200/30 dark:bg-purple-900/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 right-1/3 w-48 h-48 bg-pink-200/30 dark:bg-pink-900/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 4s;"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="animate-fade-in-up">
            <h1 class="text-5xl md:text-7xl font-bold mb-6">
                <span class="gradient-text">Creative</span>
                <br>
                <span class="text-gray-900 dark:text-gray-100">Portfolio</span>
            </h1>
            
            <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-400 mb-8 max-w-3xl mx-auto leading-relaxed">
                Passionate about creating digital experiences that inspire and connect. 
                Welcome to my world of design, code, and creativity.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-16 sm:mb-8">
                <a href="{{ route('portfolio.index') }}" class="btn-primary">
                    View My Work
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
                <a href="{{ route('about') }}" class="btn-secondary">
                    Learn More About Me
                </a>
            </div>
        </div>
        
        <!-- Scroll indicator -->
        <div class="absolute bottom-6 sm:bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <div class="p-2">
                <svg class="w-6 h-6 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
        </div>
    </div>
</section>

<!-- Featured Projects Section -->
@if($featuredProjects->count() > 0)
<section class="py-20 bg-white dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                Featured <span class="gradient-text">Projects</span>
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                A showcase of my latest and most exciting work. Each project tells a unique story.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredProjects as $project)
            <div class="group relative bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden card-hover">
                <!-- Project Image -->
                <div class="aspect-video overflow-hidden">
                    <x-curator-image 
                        :media="$project"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                        :alt="$project->title"
                    />
                </div>
                
                <!-- Project Info -->
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                        {{ $project->title }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                        {{ $project->description }}
                    </p>
                    
                    <!-- Technologies -->
                    @if($project->technologies && count($project->technologies) > 0)
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach(array_slice($project->technologies, 0, 3) as $tech)
                        <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-sm rounded-full">
                            {{ $tech }}
                        </span>
                        @endforeach
                        @if(count($project->technologies) > 3)
                        <span class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-sm rounded-full">
                            +{{ count($project->technologies) - 3 }} more
                        </span>
                        @endif
                    </div>
                    @endif
                    
                    <a href="{{ route('portfolio.show', $project->slug) }}" 
                       class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold transition-colors">
                        View Project
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('portfolio.index') }}" class="btn-secondary">
                View All Projects
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Recent Blog Posts Section -->
@if($recentPosts->count() > 0)
<section class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                Latest <span class="gradient-text">Insights</span>
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Thoughts, tutorials, and stories from my creative journey. Stay updated with my latest posts.
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @foreach($recentPosts as $post)
            <article class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden card-hover">
                <!-- Post Image -->
                <div class="aspect-video overflow-hidden">
                    <x-curator-image 
                        :media="$post"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                        :alt="$post->title"
                    />
                </div>
                
                <!-- Post Content -->
                <div class="p-6">
                    <!-- Category & Date -->
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-sm rounded-full">
                            {{ $post->category->name }}
                        </span>
                        <time class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $post->published_at->format('M d, Y') }}
                        </time>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-3 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h3>
                    
                    <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                        {{ $post->excerpt }}
                    </p>
                    
                    <!-- Author & Read More -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-semibold">
                                    {{ substr($post->user->name, 0, 1) }}
                                </span>
                            </div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $post->user->name }}</span>
                        </div>
                        
                        <a href="{{ route('blog.show', $post->slug) }}" 
                           class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold text-sm transition-colors">
                            Read More →
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('blog.index') }}" class="btn-secondary">
                Read All Posts
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-br from-blue-600 to-purple-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl md:text-5xl font-bold mb-6">
            Let's Create Something
            <br>
            <span class="text-blue-200">Amazing Together</span>
        </h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
            Have a project in mind? I'm always excited to collaborate on new ideas and bring creative visions to life.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ route('contact') }}" 
               class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 focus:ring-offset-blue-600 transition-all duration-200">
                Get In Touch
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </a>
            <a href="{{ route('portfolio.index') }}" 
               class="inline-flex items-center px-8 py-4 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600 transition-all duration-200">
                View Portfolio
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Add intersection observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in-up');
            }
        });
    }, observerOptions);
    
    // Observe all cards for animation
    document.querySelectorAll('.card-hover').forEach(card => {
        observer.observe(card);
    });
</script>
@endpush