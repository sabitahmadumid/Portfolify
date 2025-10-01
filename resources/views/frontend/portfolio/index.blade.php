@extends('frontend.layouts.app')

@section('title', 'Portfolio - Creative Projects & Work')
@section('description', 'Explore my portfolio of creative projects, web development work, and digital experiences.')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-950 dark:to-gray-900">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 right-1/4 w-64 h-64 bg-blue-200/20 dark:bg-blue-900/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 left-1/4 w-96 h-96 bg-purple-200/20 dark:bg-purple-900/10 rounded-full blur-3xl"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl md:text-6xl font-bold text-gray-900 dark:text-gray-100 mb-6">
            My <span class="gradient-text">Portfolio</span>
        </h1>
        <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto mb-8">
            A collection of projects that showcase my passion for creating digital experiences. 
            Each project tells a story of innovation, creativity, and technical excellence.
        </p>
        
        <!-- Filter Options -->
        <div class="flex flex-wrap gap-3 justify-center items-center">
            <a href="{{ route('portfolio.index') }}" 
               class="px-6 py-2 rounded-full {{ !request('technology') && !request('featured') ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }} font-medium transition-all duration-200">
                All Projects
            </a>
            <a href="{{ route('portfolio.index', ['featured' => 'true']) }}" 
               class="px-6 py-2 rounded-full {{ request('featured') ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }} font-medium transition-all duration-200">
                Featured
            </a>
            @foreach($allTechnologies->take(5) as $tech)
            <a href="{{ route('portfolio.index', ['technology' => $tech]) }}" 
               class="px-4 py-2 rounded-full {{ request('technology') === $tech ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }} text-sm font-medium transition-all duration-200">
                {{ $tech }}
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Projects Grid -->
<section class="py-20 bg-white dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($portfolios->count() > 0)
            <!-- Results Info -->
            <div class="mb-8 text-center">
                <p class="text-gray-600 dark:text-gray-400">
                    Showing {{ $portfolios->count() }} of {{ $portfolios->total() }} projects
                    @if(request('technology'))
                        for <span class="font-semibold text-blue-600 dark:text-blue-400">{{ request('technology') }}</span>
                    @endif
                    @if(request('featured'))
                        <span class="font-semibold text-blue-600 dark:text-blue-400">(Featured Only)</span>
                    @endif
                </p>
            </div>
            
            <!-- Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($portfolios as $portfolio)
                <div class="group bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden card-hover">
                    <!-- Project Image -->
                    <div class="relative aspect-video overflow-hidden">
                        @if($portfolio->featuredImage)
                            <img 
                                src="{{ $portfolio->featuredImage->url }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                alt="{{ $portfolio->title }}"
                                loading="lazy"
                            />
                        @else
                            <!-- Placeholder -->
                            <div class="w-full h-full bg-gradient-to-br from-blue-500 via-purple-600 to-pink-500 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center mb-2 mx-auto">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-white text-sm font-medium">{{ $portfolio->title }}</p>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Featured Badge -->
                        @if($portfolio->is_featured)
                        <div class="absolute top-4 left-4 px-3 py-1 bg-yellow-500 text-white text-sm font-semibold rounded-full">
                            Featured
                        </div>
                        @endif
                        
                        <!-- Quick Actions -->
                        <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="flex space-x-2">
                                @if($portfolio->live_url)
                                <a href="{{ $portfolio->live_url }}" 
                                   target="_blank"
                                   class="p-2 bg-white/90 dark:bg-gray-800/90 rounded-full hover:bg-white dark:hover:bg-gray-800 transition-colors">
                                    <svg class="w-4 h-4 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </a>
                                @endif
                                @if($portfolio->github_url)
                                <a href="{{ $portfolio->github_url }}" 
                                   target="_blank"
                                   class="p-2 bg-white/90 dark:bg-gray-800/90 rounded-full hover:bg-white dark:hover:bg-gray-800 transition-colors">
                                    <svg class="w-4 h-4 text-gray-700 dark:text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 0C5.374 0 0 5.373 0 12 0 17.302 3.438 21.8 8.207 23.387c.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>
                                    </svg>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Project Info -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            {{ $portfolio->title }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                            {{ $portfolio->description }}
                        </p>
                        
                        <!-- Technologies -->
                        @if($portfolio->technologies && count($portfolio->technologies) > 0)
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach(array_slice($portfolio->technologies, 0, 3) as $tech)
                            <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-sm rounded-full">
                                {{ $tech }}
                            </span>
                            @endforeach
                            @if(count($portfolio->technologies) > 3)
                            <span class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-sm rounded-full">
                                +{{ count($portfolio->technologies) - 3 }}
                            </span>
                            @endif
                        </div>
                        @endif
                        
                        <!-- Actions -->
                        <div class="flex items-center justify-between">
                            <a href="{{ route('portfolio.show', $portfolio->slug) }}" 
                               class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold transition-colors">
                                View Details
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                            
                            @if($portfolio->live_url)
                            <a href="{{ $portfolio->live_url }}" 
                               target="_blank"
                               class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($portfolios->hasPages())
            <div class="mt-12">
                {{ $portfolios->links() }}
            </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">No Projects Found</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    @if(request('technology') || request('featured'))
                        No projects match your current filters. Try adjusting your search criteria.
                    @else
                        No projects have been published yet. Check back soon for updates!
                    @endif
                </p>
                <a href="{{ route('portfolio.index') }}" class="btn-primary">
                    View All Projects
                </a>
            </div>
        @endif
    </div>
</section>
@endsection