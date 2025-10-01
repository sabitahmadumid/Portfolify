@extends('frontend.layouts.app')

@section('title', $portfolio->title . ' - Portfolio Project')
@section('description', $portfolio->description)

@section('content')
<!-- Hero Section -->
<section class="relative py-20 bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-950 dark:to-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">Home</a></li>
                <li class="text-gray-400">/</li>
                <li><a href="{{ route('portfolio.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">Portfolio</a></li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-900 dark:text-gray-100 font-medium">{{ $portfolio->title }}</li>
            </ol>
        </nav>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Project Info -->
            <div class="order-2 lg:order-1">
                @if($portfolio->is_featured)
                <div class="inline-flex items-center px-4 py-2 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 rounded-full text-sm font-semibold mb-4">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    Featured Project
                </div>
                @endif
                
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-gray-100 mb-6">
                    {{ $portfolio->title }}
                </h1>
                
                <p class="text-xl text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                    {{ $portfolio->description }}
                </p>
                
                <!-- Technologies -->
                @if($portfolio->technologies && count($portfolio->technologies) > 0)
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Technologies Used</h3>
                    <div class="flex flex-wrap gap-3">
                        @foreach($portfolio->technologies as $tech)
                        <span class="px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full font-medium">
                            {{ $tech }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    @if($portfolio->live_url)
                    <a href="{{ $portfolio->live_url }}" 
                       target="_blank"
                       class="btn-primary">
                        View Live Project
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                    @endif
                    
                    @if($portfolio->github_url)
                    <a href="{{ $portfolio->github_url }}" 
                       target="_blank"
                       class="btn-secondary">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.374 0 0 5.373 0 12 0 17.302 3.438 21.8 8.207 23.387c.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>
                        </svg>
                        View Source Code
                    </a>
                    @endif
                </div>
            </div>
            
            <!-- Project Image -->
            <div class="order-1 lg:order-2">
                <div class="relative aspect-video rounded-2xl overflow-hidden shadow-2xl">
                    @if($portfolio->featuredImage)
                        <img 
                            src="{{ $portfolio->featuredImage->url }}"
                            class="w-full h-full object-cover"
                            alt="{{ $portfolio->title }}"
                            loading="eager"
                        />
                    @else
                        <!-- Placeholder -->
                        <div class="w-full h-full bg-gradient-to-br from-blue-500 via-purple-600 to-pink-500 flex items-center justify-center">
                            <div class="text-center">
                                <div class="w-20 h-20 bg-white/20 rounded-xl flex items-center justify-center mb-3 mx-auto">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <p class="text-white font-medium">{{ $portfolio->title }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Project Details -->
@if($portfolio->content)
<section class="py-16 bg-white dark:bg-gray-950">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-lg dark:prose-invert mx-auto">
            {!! $portfolio->content !!}
        </div>
    </div>
</section>
@endif

<!-- Gallery Section -->
@if($portfolio->gallery && count($portfolio->gallery) > 0)
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8 text-center">Project Gallery</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($portfolio->gallery as $image)
            <div class="aspect-video bg-gray-200 dark:bg-gray-700 rounded-xl overflow-hidden group cursor-pointer hover:shadow-xl transition-all duration-300">
                <img src="{{ $image }}" 
                     alt="Gallery image for {{ $portfolio->title }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                     onclick="openLightbox('{{ $image }}')">
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Project Stats -->
<section class="py-16 bg-white dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="p-6">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Project Duration</h3>
                <p class="text-gray-600 dark:text-gray-400">{{ $portfolio->duration ?? '2-4 weeks' }}</p>
            </div>
            
            <div class="p-6">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Project Status</h3>
                <p class="text-green-600 dark:text-green-400 font-semibold">Completed</p>
            </div>
            
            <div class="p-6">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Project Type</h3>
                <p class="text-gray-600 dark:text-gray-400">{{ $portfolio->project_type ?? 'Web Development' }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Related Projects -->
@if($relatedProjects->count() > 0)
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8 text-center">More Projects</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($relatedProjects as $project)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden card-hover">
                <!-- Project Image -->
                <div class="aspect-video bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 overflow-hidden">
                    @if($project->featuredImage)
                        <img 
                            src="{{ $project->featuredImage->url }}"
                            alt="{{ $project->title }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            loading="lazy"
                        />
                    @else
                        <!-- Placeholder -->
                        <div class="w-full h-full bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center">
                            <div class="text-center">
                                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mb-2 mx-auto">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <p class="text-white text-xs font-medium">{{ $project->title }}</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $project->title }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">{{ $project->description }}</p>
                    <a href="{{ route('portfolio.show', $project->slug) }}" 
                       class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold">
                        View Project →
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-br from-blue-600 to-purple-700 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Like What You See?</h2>
        <p class="text-xl text-blue-100 mb-8">
            Let's collaborate on your next project and create something amazing together.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact') }}" 
               class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition-colors">
                Start a Project
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
            <a href="{{ route('portfolio.index') }}" 
               class="inline-flex items-center px-8 py-4 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-blue-600 transition-all duration-200">
                View All Projects
            </a>
        </div>
    </div>
</section>

<!-- Lightbox Modal -->
<div id="lightbox" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden items-center justify-center">
    <div class="relative max-w-4xl max-h-full p-4">
        <img id="lightbox-image" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
        <button onclick="closeLightbox()" 
                class="absolute top-4 right-4 text-white hover:text-gray-300 bg-black bg-opacity-50 rounded-full p-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openLightbox(imageSrc) {
        const lightbox = document.getElementById('lightbox');
        document.getElementById('lightbox-image').src = imageSrc;
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    
    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.add('hidden');
        lightbox.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }
    
    // Close lightbox on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
    
    // Close lightbox when clicking outside the image
    document.getElementById('lightbox').addEventListener('click', function(e) {
        if (e.target === this) {
            closeLightbox();
        }
    });
</script>
@endpush