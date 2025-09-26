<?php $__env->startSection('title', 'Blog - Insights & Stories'); ?>
<?php $__env->startSection('description', 'Discover insights, tutorials, and stories from my creative journey. Stay updated with the latest posts and trends.'); ?>

<?php $__env->startSection('content'); ?>
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
                                   value="<?php echo e(request('search')); ?>"
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
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->slug); ?>" <?php echo e(request('category') === $category->slug ? 'selected' : ''); ?>>
                                <?php echo e($category->name); ?> (<?php echo e($category->published_posts_count); ?>)
                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
            <?php if(request()->filled('search') || request()->filled('category') || request()->filled('tag')): ?>
            <div class="flex flex-wrap items-center gap-2 mb-8">
                <span class="text-sm text-gray-600 dark:text-gray-400">Active filters:</span>
                
                <?php if(request('search')): ?>
                <div class="flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full text-sm">
                    Search: "<?php echo e(request('search')); ?>"
                    <a href="<?php echo e(request()->url()); ?>?<?php echo e(http_build_query(request()->except('search'))); ?>" 
                       class="ml-2 hover:text-blue-600 dark:hover:text-blue-400">×</a>
                </div>
                <?php endif; ?>
                
                <?php if(request('category')): ?>
                <div class="flex items-center px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 rounded-full text-sm">
                    Category: <?php echo e($categories->where('slug', request('category'))->first()->name ?? request('category')); ?>

                    <a href="<?php echo e(request()->url()); ?>?<?php echo e(http_build_query(request()->except('category'))); ?>" 
                       class="ml-2 hover:text-purple-600 dark:hover:text-purple-400">×</a>
                </div>
                <?php endif; ?>
                
                <?php if(request('tag')): ?>
                <div class="flex items-center px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-full text-sm">
                    Tag: <?php echo e(request('tag')); ?>

                    <a href="<?php echo e(request()->url()); ?>?<?php echo e(http_build_query(request()->except('tag'))); ?>" 
                       class="ml-2 hover:text-green-600 dark:hover:text-green-400">×</a>
                </div>
                <?php endif; ?>
                
                <a href="<?php echo e(route('blog.index')); ?>" 
                   class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 underline">
                    Clear all
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-16 bg-white dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if($posts->count() > 0): ?>
            <!-- Results Info -->
            <div class="mb-8 text-center">
                <p class="text-gray-600 dark:text-gray-400">
                    Showing <?php echo e($posts->count()); ?> of <?php echo e($posts->total()); ?> articles
                    <?php if(request()->filled('search') || request()->filled('category') || request()->filled('tag')): ?>
                        matching your criteria
                    <?php endif; ?>
                </p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <!-- Featured Posts (only on first page without filters) -->
                    <?php if($featuredPosts->count() > 0 && !request()->hasAny(['search', 'category', 'tag']) && $posts->currentPage() === 1): ?>
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Featured Articles</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <?php $__currentLoopData = $featuredPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featured): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <article class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden card-hover">
                                <!-- Featured Image -->
                                <div class="aspect-video overflow-hidden relative">
                                    <?php if (isset($component)) { $__componentOriginalbc783e37f5cb2b202a9dbb55de70b932 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc783e37f5cb2b202a9dbb55de70b932 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.curator-image','data' => ['media' => $featured,'class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-500','alt' => $featured->title]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('curator-image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['media' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($featured),'class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-500','alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($featured->title)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbc783e37f5cb2b202a9dbb55de70b932)): ?>
<?php $attributes = $__attributesOriginalbc783e37f5cb2b202a9dbb55de70b932; ?>
<?php unset($__attributesOriginalbc783e37f5cb2b202a9dbb55de70b932); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbc783e37f5cb2b202a9dbb55de70b932)): ?>
<?php $component = $__componentOriginalbc783e37f5cb2b202a9dbb55de70b932; ?>
<?php unset($__componentOriginalbc783e37f5cb2b202a9dbb55de70b932); ?>
<?php endif; ?>
                                    
                                    <!-- Featured Badge -->
                                    <div class="absolute top-3 left-3 px-2 py-1 bg-yellow-500 text-white text-xs font-semibold rounded-full">
                                        Featured
                                    </div>
                                </div>
                                
                                <!-- Content -->
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-sm rounded-full">
                                            <?php echo e($featured->category->name); ?>

                                        </span>
                                        <time class="text-sm text-gray-500 dark:text-gray-400">
                                            <?php echo e($featured->published_at->format('M d, Y')); ?>

                                        </time>
                                    </div>
                                    
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                        <a href="<?php echo e(route('blog.show', $featured->slug)); ?>"><?php echo e($featured->title); ?></a>
                                    </h3>
                                    
                                    <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2 mb-3">
                                        <?php echo e($featured->excerpt); ?>

                                    </p>
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                                <span class="text-white text-xs font-semibold">
                                                    <?php echo e(substr($featured->user->name, 0, 1)); ?>

                                                </span>
                                            </div>
                                            <span class="text-sm text-gray-600 dark:text-gray-400"><?php echo e($featured->user->name); ?></span>
                                        </div>
                                        
                                        <a href="<?php echo e(route('blog.show', $featured->slug)); ?>" 
                                           class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold text-sm transition-colors">
                                            Read →
                                        </a>
                                    </div>
                                </div>
                            </article>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- All Posts -->
                    <div class="space-y-8">
                        <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                            <div class="flex flex-col md:flex-row">
                                <!-- Post Image -->
                                <div class="md:w-1/3">
                                    <div class="aspect-video md:aspect-square overflow-hidden">
                                        <?php if (isset($component)) { $__componentOriginalbc783e37f5cb2b202a9dbb55de70b932 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc783e37f5cb2b202a9dbb55de70b932 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.curator-image','data' => ['media' => $post,'class' => 'w-full h-full object-cover hover:scale-110 transition-transform duration-500','alt' => $post->title]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('curator-image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['media' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post),'class' => 'w-full h-full object-cover hover:scale-110 transition-transform duration-500','alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post->title)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbc783e37f5cb2b202a9dbb55de70b932)): ?>
<?php $attributes = $__attributesOriginalbc783e37f5cb2b202a9dbb55de70b932; ?>
<?php unset($__attributesOriginalbc783e37f5cb2b202a9dbb55de70b932); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbc783e37f5cb2b202a9dbb55de70b932)): ?>
<?php $component = $__componentOriginalbc783e37f5cb2b202a9dbb55de70b932; ?>
<?php unset($__componentOriginalbc783e37f5cb2b202a9dbb55de70b932); ?>
<?php endif; ?>
                                    </div>
                                </div>
                                
                                <!-- Post Content -->
                                <div class="md:w-2/3 p-6">
                                    <!-- Meta -->
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-sm rounded-full">
                                                <?php echo e($post->category->name); ?>

                                            </span>
                                            <?php if($post->is_featured): ?>
                                            <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 text-sm rounded-full">
                                                Featured
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                        <time class="text-sm text-gray-500 dark:text-gray-400">
                                            <?php echo e($post->published_at->format('M d, Y')); ?>

                                        </time>
                                    </div>
                                    
                                    <!-- Title -->
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-3 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                        <a href="<?php echo e(route('blog.show', $post->slug)); ?>"><?php echo e($post->title); ?></a>
                                    </h2>
                                    
                                    <!-- Excerpt -->
                                    <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                                        <?php echo e($post->excerpt); ?>

                                    </p>
                                    
                                    <!-- Tags -->
                                    <?php if($post->tags && count($post->tags) > 0): ?>
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        <?php $__currentLoopData = array_slice($post->tags, 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(route('blog.index', ['tag' => $tag])); ?>" 
                                           class="px-2 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-sm rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                            #<?php echo e($tag); ?>

                                        </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <!-- Footer -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                                <span class="text-white text-sm font-semibold">
                                                    <?php echo e(substr($post->user->name, 0, 1)); ?>

                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100"><?php echo e($post->user->name); ?></p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(number_format($post->views_count ?? 0)); ?> views</p>
                                            </div>
                                        </div>
                                        
                                        <a href="<?php echo e(route('blog.show', $post->slug)); ?>" 
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
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if($posts->hasPages()): ?>
                    <div class="mt-12">
                        <?php echo e($posts->links()); ?>

                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="space-y-8">
                        <!-- Categories -->
                        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-lg">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Categories</h3>
                            <div class="space-y-2">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('blog.category', $category->slug)); ?>" 
                                   class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors group">
                                    <span class="text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                        <?php echo e($category->name); ?>

                                    </span>
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-sm rounded">
                                        <?php echo e($category->published_posts_count); ?>

                                    </span>
                                </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        <?php else: ?>
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">No Articles Found</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    <?php if(request()->hasAny(['search', 'category', 'tag'])): ?>
                        No articles match your current search criteria. Try adjusting your filters.
                    <?php else: ?>
                        No articles have been published yet. Check back soon for updates!
                    <?php endif; ?>
                </p>
                <a href="<?php echo e(route('blog.index')); ?>" class="btn-primary">
                    View All Articles
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/xcalibur/Herd/portfolify/resources/views/frontend/blog/index.blade.php ENDPATH**/ ?>