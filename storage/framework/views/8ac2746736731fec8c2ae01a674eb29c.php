<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', $seoSettings['default_meta_title'] ?? $globalSettings['site_name']); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('description', $seoSettings['default_meta_description'] ?? $globalSettings['site_description']); ?>">

    <?php if($seoSettings['google_site_verification']): ?>
    <meta name="google-site-verification" content="<?php echo e($seoSettings['google_site_verification']); ?>">
    <?php endif; ?>

    <?php if($seoSettings['bing_site_verification']): ?>
    <meta name="msvalidate.01" content="<?php echo e($seoSettings['bing_site_verification']); ?>">
    <?php endif; ?>

    <?php if($seoSettings['enable_open_graph']): ?>
    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo $__env->yieldContent('og_title', $seoSettings['default_meta_title'] ?? $globalSettings['site_name']); ?>">
    <meta property="og:description" content="<?php echo $__env->yieldContent('og_description', $seoSettings['default_meta_description'] ?? $globalSettings['site_description']); ?>">
    <meta property="og:type" content="<?php echo $__env->yieldContent('og_type', 'website'); ?>">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta property="og:site_name" content="<?php echo e($globalSettings['site_name']); ?>">
    <?php if($seoSettings['og_image']): ?>
    <meta property="og:image" content="<?php echo e($seoSettings['og_image']); ?>">
    <?php endif; ?>
    <?php endif; ?>

    <?php if($seoSettings['enable_twitter_cards']): ?>
    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <?php if($seoSettings['twitter_handle']): ?>
    <meta name="twitter:site" content="{{ $seoSettings['twitter_handle'] }}">
    <?php endif; ?>
    <meta name="twitter:title" content="<?php echo $__env->yieldContent('twitter_title', $seoSettings['default_meta_title'] ?? $globalSettings['site_name']); ?>">
    <meta name="twitter:description" content="<?php echo $__env->yieldContent('twitter_description', $seoSettings['default_meta_description'] ?? $globalSettings['site_description']); ?>">
    <?php if($seoSettings['og_image']): ?>
    <meta name="twitter:image" content="<?php echo e($seoSettings['og_image']); ?>">
    <?php endif; ?>
    <?php endif; ?>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <!-- Dynamic Theme Colors -->
    <style>
        :root {
            --primary-color: <?php echo e($globalSettings['primary_color'] ?? '#3B82F6'); ?>;
            --secondary-color: <?php echo e($globalSettings['secondary_color'] ?? '#8B5CF6'); ?>;
            --primary-rgb: <?php echo e(implode(', ', sscanf($globalSettings['primary_color'] ?? '#3B82F6', '#%02x%02x%02x'))); ?>;
            --secondary-rgb: <?php echo e(implode(', ', sscanf($globalSettings['secondary_color'] ?? '#8B5CF6', '#%02x%02x%02x'))); ?>;
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

    <?php if($seoSettings['enable_schema_markup']): ?>
        <!-- Schema.org structured data -->
        <?php
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
        ?>
        <script type="application/ld+json">
            <?php echo json_encode($schemaData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>

        </script>
    <?php endif; ?>

    <?php if($seoSettings['google_analytics_id']): ?>
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e($seoSettings['google_analytics_id']); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?php echo e($seoSettings['google_analytics_id']); ?>');
    </script>
    <?php endif; ?>

    <?php if($seoSettings['custom_head_code']): ?>
    <!-- Custom Head Code -->
    <?php echo $seoSettings['custom_head_code']; ?>

    <?php endif; ?>

    <?php echo $__env->yieldPushContent('head'); ?>
</head>
<body class="font-sans antialiased bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100 selection:bg-blue-500/20">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="sticky top-0 z-50 backdrop-blur-xl bg-white/80 dark:bg-gray-950/80 border-b border-gray-200/50 dark:border-gray-800/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="<?php echo e(route('home')); ?>" class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-sm"><?php echo e(substr($globalSettings['site_name'], 0, 1)); ?></span>
                            </div>
                            <span class="font-bold text-xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                <?php echo e($globalSettings['site_name']); ?>

                            </span>
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-8">
                            <a href="<?php echo e(route('home')); ?>"
                               class="nav-link <?php echo e(request()->routeIs('home') ? 'nav-link-active' : ''); ?>">
                                Home
                            </a>
                            <a href="<?php echo e(route('portfolio.index')); ?>"
                               class="nav-link <?php echo e(request()->routeIs('portfolio.*') ? 'nav-link-active' : ''); ?>">
                                Portfolio
                            </a>
                            <a href="<?php echo e(route('blog.index')); ?>"
                               class="nav-link <?php echo e(request()->routeIs('blog.*') ? 'nav-link-active' : ''); ?>">
                                Blog
                            </a>
                            <a href="<?php echo e(route('about')); ?>"
                               class="nav-link <?php echo e(request()->routeIs('about') ? 'nav-link-active' : ''); ?>">
                                About
                            </a>
                            <a href="<?php echo e(route('contact')); ?>"
                               class="nav-link <?php echo e(request()->routeIs('contact') ? 'nav-link-active' : ''); ?>">
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
                    <a href="<?php echo e(route('home')); ?>"
                       class="mobile-nav-link <?php echo e(request()->routeIs('home') ? 'mobile-nav-link-active' : ''); ?>">
                        Home
                    </a>
                    <a href="<?php echo e(route('portfolio.index')); ?>"
                       class="mobile-nav-link <?php echo e(request()->routeIs('portfolio.*') ? 'mobile-nav-link-active' : ''); ?>">
                        Portfolio
                    </a>
                    <a href="<?php echo e(route('blog.index')); ?>"
                       class="mobile-nav-link <?php echo e(request()->routeIs('blog.*') ? 'mobile-nav-link-active' : ''); ?>">
                        Blog
                    </a>
                    <a href="<?php echo e(route('about')); ?>"
                       class="mobile-nav-link <?php echo e(request()->routeIs('about') ? 'mobile-nav-link-active' : ''); ?>">
                        About
                    </a>
                    <a href="<?php echo e(route('contact')); ?>"
                       class="mobile-nav-link <?php echo e(request()->routeIs('contact') ? 'mobile-nav-link-active' : ''); ?>">
                        Contact
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Brand -->
                    <div class="md:col-span-2">
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-sm">P</span>
                            </div>
                            <span class="font-bold text-xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                Portfolify
                            </span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 max-w-md">
                            Creating digital experiences that inspire and connect. Passionate about design, technology, and storytelling.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">Quick Links</h3>
                        <ul class="space-y-2">
                            <li><a href="<?php echo e(route('home')); ?>" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Home</a></li>
                            <li><a href="<?php echo e(route('portfolio.index')); ?>" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Portfolio</a></li>
                            <li><a href="<?php echo e(route('blog.index')); ?>" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Blog</a></li>
                            <li><a href="<?php echo e(route('about')); ?>" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">About</a></li>
                        </ul>
                    </div>

                    <!-- Connect -->
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">Connect</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.347-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.161-1.499-.698-2.436-2.888-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.357-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-800 mt-8 pt-8 text-center">
                    <p class="text-gray-600 dark:text-gray-400">
                        © <?php echo e(date('Y')); ?> Portfolify. All rights reserved. Built with ❤️ using Laravel & Tailwind CSS.
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Theme toggle functionality
        function toggleTheme() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');

            if (isDark) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }

        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        // Initialize theme
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobile-menu');
            const button = event.target.closest('button');

            if (!menu.contains(event.target) && !button) {
                menu.classList.add('hidden');
            }
        });
    </script>

    <!-- Toast Component -->
    <?php if (isset($component)) { $__componentOriginal7cfab914afdd05940201ca0b2cbc009b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7cfab914afdd05940201ca0b2cbc009b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.toast','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('toast'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7cfab914afdd05940201ca0b2cbc009b)): ?>
<?php $attributes = $__attributesOriginal7cfab914afdd05940201ca0b2cbc009b; ?>
<?php unset($__attributesOriginal7cfab914afdd05940201ca0b2cbc009b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7cfab914afdd05940201ca0b2cbc009b)): ?>
<?php $component = $__componentOriginal7cfab914afdd05940201ca0b2cbc009b; ?>
<?php unset($__componentOriginal7cfab914afdd05940201ca0b2cbc009b); ?>
<?php endif; ?>

    <?php if($seoSettings['custom_body_code']): ?>
    <!-- Custom Body Code -->
    <?php echo $seoSettings['custom_body_code']; ?>

    <?php endif; ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /Users/xcalibur/Herd/portfolify/resources/views/frontend/layouts/app.blade.php ENDPATH**/ ?>