<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Quick Actions
        </x-slot>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            <a href="{{ route('filament.admin.resources.posts.create') }}" 
               class="group block p-5 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/30 rounded-xl border border-blue-100 dark:border-blue-800 hover:border-blue-200 dark:hover:border-blue-700 transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-blue-100 dark:bg-blue-900 rounded-lg group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div class="ml-4 min-w-0 flex-1">
                        <p class="text-sm font-semibold text-blue-900 dark:text-blue-100 truncate">New Post</p>
                        <p class="text-xs text-blue-600 dark:text-blue-300 mt-0.5">Create a new blog post</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('filament.admin.resources.portfolios.create') }}" 
               class="group block p-5 bg-green-50 hover:bg-green-100 dark:bg-green-900/20 dark:hover:bg-green-900/30 rounded-xl border border-green-100 dark:border-green-800 hover:border-green-200 dark:hover:border-green-700 transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-green-100 dark:bg-green-900 rounded-lg group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="ml-4 min-w-0 flex-1">
                        <p class="text-sm font-semibold text-green-900 dark:text-green-100 truncate">New Portfolio</p>
                        <p class="text-xs text-green-600 dark:text-green-300 mt-0.5">Add portfolio project</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('filament.admin.resources.categories.create') }}" 
               class="group block p-5 bg-purple-50 hover:bg-purple-100 dark:bg-purple-900/20 dark:hover:bg-purple-900/30 rounded-xl border border-purple-100 dark:border-purple-800 hover:border-purple-200 dark:hover:border-purple-700 transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-purple-100 dark:bg-purple-900 rounded-lg group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div class="ml-4 min-w-0 flex-1">
                        <p class="text-sm font-semibold text-purple-900 dark:text-purple-100 truncate">New Category</p>
                        <p class="text-xs text-purple-600 dark:text-purple-300 mt-0.5">Create content category</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('filament.admin.resources.users.create') }}" 
               class="group block p-5 bg-orange-50 hover:bg-orange-100 dark:bg-orange-900/20 dark:hover:bg-orange-900/30 rounded-xl border border-orange-100 dark:border-orange-800 hover:border-orange-200 dark:hover:border-orange-700 transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-orange-100 dark:bg-orange-900 rounded-lg group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-4 min-w-0 flex-1">
                        <p class="text-sm font-semibold text-orange-900 dark:text-orange-100 truncate">New User</p>
                        <p class="text-xs text-orange-600 dark:text-orange-300 mt-0.5">Add new user account</p>
                    </div>
                </div>
            </a>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>