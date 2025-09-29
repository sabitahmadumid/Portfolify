<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $seoSettings['default_meta_title'] ?? $globalSettings['site_name'])</title>
    <meta name="description" content="@yield('description', $seoSettings['default_meta_description'] ?? $globalSettings['site_description'])">

    @if($seoSettings['google_site_verification'])
    <meta name="google-site-verification" content="{{ $seoSettings['google_site_verification'] }}">
    @endif

    @if($seoSettings['bing_site_verification'])
    <meta name="msvalidate.01" content="{{ $seoSettings['bing_site_verification'] }}">
    @endif

    @if($seoSettings['enable_open_graph'])
    <!-- Open Graph -->
    <meta property="og:title" content="@yield('og_title', $seoSettings['default_meta_title'] ?? $globalSettings['site_name'])">
    <meta property="og:description" content="@yield('og_description', $seoSettings['default_meta_description'] ?? $globalSettings['site_description'])">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ $globalSettings['site_name'] }}">
    @if($seoSettings['og_image'])
    <meta property="og:image" content="{{ $seoSettings['og_image'] }}">
    @endif
    @endif

    @if($seoSettings['enable_twitter_cards'])
    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    @if($seoSettings['twitter_handle'])
    <meta name="twitter:site" content="@{{ $seoSettings['twitter_handle'] }}">
    @endif
    <meta name="twitter:title" content="@yield('twitter_title', $seoSettings['default_meta_title'] ?? $globalSettings['site_name'])">
    <meta name="twitter:description" content="@yield('twitter_description', $seoSettings['default_meta_description'] ?? $globalSettings['site_description'])">
    @if($seoSettings['og_image'])
    <meta name="twitter:image" content="{{ $seoSettings['og_image'] }}">
    @endif
    @endif

    <!-- Favicon -->
    @if($globalSettings['site_favicon_url'])
        <link rel="icon" type="image/x-icon" href="{{ $globalSettings['site_favicon_url'] }}">
        <link rel="apple-touch-icon" href="{{ $globalSettings['site_favicon_url'] }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Dynamic Theme Colors -->
    <style>
        :root {
            --primary-color: {{ $globalSettings['primary_color'] ?? '#3B82F6' }};
            --secondary-color: {{ $globalSettings['secondary_color'] ?? '#8B5CF6' }};
            --primary-rgb: {{ implode(', ', sscanf($globalSettings['primary_color'] ?? '#3B82F6', '#%02x%02x%02x')) }};
            --secondary-rgb: {{ implode(', ', sscanf($globalSettings['secondary_color'] ?? '#8B5CF6', '#%02x%02x%02x')) }};
        }

        /* Apply dynamic colors */
        .bg-primary { background-color: var(--primary-color) !important; }
        .text-primary { color: var(--primary-color) !important; }
        .border-primary { border-color: var(--primary-color) !important; }
        .bg-secondary { background-color: var(--secondary-color) !important; }
        .text-secondary { color: var(--secondary-color) !important; }
        .border-secondary { border-color: var(--secondary-color) !important; }

        /* Dynamic gradients */
        .gradient-primary-secondary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
        }

        /* Dynamic hover effects */
        .hover\:bg-primary:hover { background-color: var(--primary-color) !important; }
        .hover\:text-primary:hover { color: var(--primary-color) !important; }
        .hover\:border-primary:hover { border-color: var(--primary-color) !important; }

        /* Dynamic focus effects */
        .focus\:ring-primary:focus {
            --tw-ring-color: rgba(var(--primary-rgb), 0.5) !important;
        }
        .focus\:border-primary:focus { border-color: var(--primary-color) !important; }
    </style>

    @if($seoSettings['enable_schema_markup'])
        <!-- Schema.org structured data -->
        @php
            $socialLinks = [];
            if (!empty($globalSettings['social_twitter'])) {
                $socialLinks[] = $globalSettings['social_twitter'];
            }
            if (!empty($globalSettings['social_linkedin'])) {
                $socialLinks[] = $globalSettings['social_linkedin'];
            }
            if (!empty($globalSettings['social_github'])) {
                $socialLinks[] = $globalSettings['social_github'];
            }
            if (!empty($globalSettings['social_instagram'])) {
                $socialLinks[] = $globalSettings['social_instagram'];
            }

            $schemaData = [
                '@context' => 'https://schema.org',
                '@type' => 'Person',
                'name' => $globalSettings['site_name'],
                'url' => url('/'),
                'description' => $globalSettings['site_description'],
            ];

            if (!empty($socialLinks)) {
                $schemaData['sameAs'] = $socialLinks;
            }
        @endphp
        <script type="application/ld+json">
            {!! json_encode($schemaData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
        </script>
    @endif

    @if($seoSettings['google_analytics_id'])
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $seoSettings['google_analytics_id'] }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $seoSettings['google_analytics_id'] }}');
    </script>
    @endif

    @if($seoSettings['custom_head_code'])
    <!-- Custom Head Code -->
    {!! $seoSettings['custom_head_code'] !!}
    @endif

    @stack('head')
</head>
<body class="font-sans antialiased bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100 selection:bg-blue-500/20">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="sticky top-0 z-50 backdrop-blur-xl bg-white/80 dark:bg-gray-950/80 border-b border-gray-200/50 dark:border-gray-800/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') }}" class="flex items-center space-x-2">
                            @if($globalSettings['site_logo'])
                                <img 
                                    src="{{ $globalSettings['site_logo']->url }}"
                                    class="h-8 w-auto"
                                    alt="{{ $globalSettings['site_name'] }}"
                                    loading="eager"
                                />
                            @else
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">{{ substr($globalSettings['site_name'], 0, 1) }}</span>
                                </div>
                            @endif
                            <span class="font-bold text-xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                {{ $globalSettings['site_name'] }}
                            </span>
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-8">
                            <a href="{{ route('home') }}"
                               class="nav-link {{ request()->routeIs('home') ? 'nav-link-active' : '' }}">
                                Home
                            </a>
                            <a href="{{ route('portfolio.index') }}"
                               class="nav-link {{ request()->routeIs('portfolio.*') ? 'nav-link-active' : '' }}">
                                Portfolio
                            </a>
                            <a href="{{ route('blog.index') }}"
                               class="nav-link {{ request()->routeIs('blog.*') ? 'nav-link-active' : '' }}">
                                Blog
                            </a>
                            <a href="{{ route('about') }}"
                               class="nav-link {{ request()->routeIs('about') ? 'nav-link-active' : '' }}">
                                About
                            </a>
                            <a href="{{ route('contact') }}"
                               class="nav-link {{ request()->routeIs('contact') ? 'nav-link-active' : '' }}">
                                Contact
                            </a>
                        </div>
                    </div>

                    <!-- Theme Toggle & Mobile Menu -->
                    <div class="flex items-center space-x-4">
                        <!-- Theme Toggle -->
                        <button type="button"
                                class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors"
                                onclick="toggleTheme()">
                            <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                            <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </button>

                        <!-- Mobile menu button -->
                        <button type="button"
                                class="md:hidden p-2 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors"
                                onclick="toggleMobileMenu()">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobile-menu" class="md:hidden hidden border-t border-gray-200 dark:border-gray-800">
                <div class="px-2 pt-2 pb-3 space-y-1 bg-white dark:bg-gray-950">
                    <a href="{{ route('home') }}"
                       class="mobile-nav-link {{ request()->routeIs('home') ? 'mobile-nav-link-active' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('portfolio.index') }}"
                       class="mobile-nav-link {{ request()->routeIs('portfolio.*') ? 'mobile-nav-link-active' : '' }}">
                        Portfolio
                    </a>
                    <a href="{{ route('blog.index') }}"
                       class="mobile-nav-link {{ request()->routeIs('blog.*') ? 'mobile-nav-link-active' : '' }}">
                        Blog
                    </a>
                    <a href="{{ route('about') }}"
                       class="mobile-nav-link {{ request()->routeIs('about') ? 'mobile-nav-link-active' : '' }}">
                        About
                    </a>
                    <a href="{{ route('contact') }}"
                       class="mobile-nav-link {{ request()->routeIs('contact') ? 'mobile-nav-link-active' : '' }}">
                        Contact
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid {{ $footerSettings['layout_columns'] }} gap-8">
                    <!-- Brand -->
                    <div class="{{ $footerSettings['brand_column_span'] }}">
                        @if($footerSettings['show_brand_logo'])
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-sm">{{ $footerSettings['brand_logo_letter'] }}</span>
                            </div>
                            <span class="font-bold text-xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                {{ $footerSettings['brand_name'] }}
                            </span>
                        </div>
                        @endif
                        @if($footerSettings['brand_description'])
                        <p class="text-gray-600 dark:text-gray-400 max-w-md">
                            {{ $footerSettings['brand_description'] }}
                        </p>
                        @endif
                    </div>

                    @if($footerSettings['show_quick_links'] && !empty($footerSettings['quick_links']))
                    <!-- Quick Links -->
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ $footerSettings['quick_links_title'] }}</h3>
                        <ul class="space-y-2">
                            @foreach($footerSettings['quick_links'] as $link)
                                @if(!empty($link['label']) && !empty($link['url']))
                                <li>
                                    <a href="{{ ($link['type'] ?? 'url') === 'route' ? route($link['url']) : $link['url'] }}" 
                                       class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
                                       @if($link['new_tab'] ?? false) target="_blank" rel="noopener noreferrer" @endif>
                                        {{ $link['label'] }}
                                    </a>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($footerSettings['show_social_links'])
                    <!-- Connect -->
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ $footerSettings['social_links_title'] }}</h3>
                        <div class="flex space-x-4">
                            @if($footerSettings['social_twitter_show'] && !empty($globalSettings['social_twitter']))
                            <a href="{{ $globalSettings['social_twitter'] }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                            @endif
                            @if($footerSettings['social_linkedin_show'] && !empty($globalSettings['social_linkedin']))
                            <a href="{{ $globalSettings['social_linkedin'] }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                            @endif
                            @if($footerSettings['social_github_show'] && !empty($globalSettings['social_github']))
                            <a href="{{ $globalSettings['social_github'] }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.347-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.161-1.499-.698-2.436-2.888-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.357-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z"/>
                                </svg>
                            </a>
                            @endif
                            @if($footerSettings['social_instagram_show'] && !empty($globalSettings['social_instagram']))
                            <a href="{{ $globalSettings['social_instagram'] }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                            @endif
                            @if($footerSettings['social_facebook_show'] && !empty($globalSettings['social_facebook']))
                            <a href="{{ $globalSettings['social_facebook'] }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            @endif
                            @if($footerSettings['social_youtube_show'] && !empty($globalSettings['social_youtube']))
                            <a href="{{ $globalSettings['social_youtube'] }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <div class="border-t border-gray-200 dark:border-gray-800 mt-8 pt-8 text-center">
                    <p class="text-gray-600 dark:text-gray-400">
                        @if($footerSettings['show_copyright_year'])© {{ date('Y') }} @endif{{ $footerSettings['brand_name'] }}. {{ $footerSettings['copyright_text'] }}
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Theme toggle functionality
        window.toggleTheme = function() {
            try {
                const html = document.documentElement;
                if (!html) return;
                
                const isDark = html.classList.contains('dark');

                if (isDark) {
                    html.classList.remove('dark');
                    if (typeof(Storage) !== "undefined") {
                        localStorage.setItem('theme', 'light');
                    }
                } else {
                    html.classList.add('dark');
                    if (typeof(Storage) !== "undefined") {
                        localStorage.setItem('theme', 'dark');
                    }
                }
            } catch (error) {
                console.error('Error toggling theme:', error);
            }
        };

        // Mobile menu toggle
        window.toggleMobileMenu = function() {
            try {
                const menu = document.getElementById('mobile-menu');
                if (menu) {
                    menu.classList.toggle('hidden');
                }
            } catch (error) {
                console.error('Error toggling mobile menu:', error);
            }
        };

        // Initialize theme on page load
        document.addEventListener('DOMContentLoaded', function() {
            try {
                if (typeof(Storage) !== "undefined") {
                    const storedTheme = localStorage.getItem('theme');
                    const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                    
                    if (storedTheme === 'dark' || (!storedTheme && prefersDark)) {
                        document.documentElement.classList.add('dark');
                    }
                }
            } catch (error) {
                console.error('Error initializing theme:', error);
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            try {
                const menu = document.getElementById('mobile-menu');
                if (!menu) return;
                
                const button = event.target.closest('button');

                if (!menu.contains(event.target) && !button) {
                    menu.classList.add('hidden');
                }
            } catch (error) {
                console.error('Error handling outside click:', error);
            }
        });
    </script>

    <!-- Toast Component -->
    <x-toast />

    @if($seoSettings['custom_body_code'])
    <!-- Custom Body Code -->
    {!! $seoSettings['custom_body_code'] !!}
    @endif

    @stack('scripts')
</body>
</html>
