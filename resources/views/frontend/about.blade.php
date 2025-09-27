@extends('frontend.layouts.app')

@section('title', 'About - Get to Know Me')
@section('description', 'Learn more about my journey, skills, and passion for creating digital experiences.')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-950 dark:to-gray-900">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 right-1/4 w-64 h-64 bg-blue-200/20 dark:bg-blue-900/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 left-1/4 w-96 h-96 bg-purple-200/20 dark:bg-purple-900/10 rounded-full blur-3xl"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Content -->
            <div class="order-2 lg:order-1">
                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 dark:text-gray-100 mb-6">
                    {{ $globalSettings['about_hero_title'] ?? 'About Me' }}
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                    {{ $globalSettings['about_hero_description'] ?? "I'm a passionate creator dedicated to crafting digital experiences that inspire and connect. With a blend of technical expertise and creative vision, I bring ideas to life through code and design." }}
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('portfolio.index') }}" class="btn-primary">
                        {{ $globalSettings['about_hero_button_work'] ?? 'View My Work' }}
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                    <a href="{{ route('contact') }}" class="btn-secondary">
                        {{ $globalSettings['about_hero_button_contact'] ?? 'Get In Touch' }}
                    </a>
                </div>
            </div>
            
            <!-- Profile Image -->
            <div class="order-1 lg:order-2">
                <div class="relative">
                    <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-3xl shadow-2xl overflow-hidden">
                        @if($globalSettings['profile_image'])
                            <img 
                                src="{{ $globalSettings['profile_image']->url }}"
                                alt="Profile Image"
                                class="w-full h-full object-cover"
                                loading="eager"
                            />
                        @else
                            <!-- Fallback placeholder when no profile image -->
                            <div class="w-full h-full flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-blue-500 to-purple-600 rounded-3xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Floating elements -->
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-blue-200/30 dark:bg-blue-900/20 rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-purple-200/30 dark:bg-purple-900/20 rounded-full blur-2xl"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Story Section -->
<section class="py-20 bg-white dark:bg-gray-950">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                {{ $globalSettings['about_journey_title'] ?? 'My Journey' }}
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Every great story has a beginning. Here's mine.
            </p>
        </div>
        
        <div class="space-y-12">
            <div class="prose prose-lg dark:prose-invert mx-auto">
                <p>
                    {{ $globalSettings['about_journey_paragraph_1'] ?? "My journey into the world of design and development began with a simple curiosity: How can technology be used to create meaningful connections and experiences? This question has driven me throughout my career, pushing me to explore the intersection of creativity, technology, and human experience." }}
                </p>
                
                <p>
                    {{ $globalSettings['about_journey_paragraph_2'] ?? "Over the years, I've had the privilege of working on diverse projects that have challenged me to grow both technically and creatively. From crafting intuitive user interfaces to building robust backend systems, I've learned that great digital experiences are born from a deep understanding of both user needs and technical possibilities." }}
                </p>
                
                <p>
                    {{ $globalSettings['about_journey_paragraph_3'] ?? "When I'm not coding or designing, you'll find me exploring new technologies, reading about emerging trends, or sharing knowledge with the community. I believe in the power of continuous learning and the importance of giving back to the community that has given me so much." }}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Skills Section -->
<section class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                {{ $globalSettings['about_skills_title'] ?? 'Skills & Expertise' }}
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                A comprehensive toolkit for bringing ideas to life.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Frontend Development -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">{{ $globalSettings['about_skill_1_title'] ?? 'Frontend Development' }}</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    {{ $globalSettings['about_skill_1_description'] ?? 'Creating responsive, accessible, and performant user interfaces with modern frameworks and tools.' }}
                </p>
                <div class="flex flex-wrap gap-2 justify-center">
                    @if(isset($globalSettings['about_skill_1_tags']) && is_array($globalSettings['about_skill_1_tags']))
                        @foreach($globalSettings['about_skill_1_tags'] as $tag)
                            <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-sm rounded-full">{{ $tag }}</span>
                        @endforeach
                    @else
                        <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-sm rounded-full">React</span>
                        <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-sm rounded-full">Vue.js</span>
                        <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-sm rounded-full">TypeScript</span>
                        <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-sm rounded-full">Tailwind CSS</span>
                    @endif
                </div>
            </div>
            
            <!-- Backend Development -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">{{ $globalSettings['about_skill_2_title'] ?? 'Backend Development' }}</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    {{ $globalSettings['about_skill_2_description'] ?? 'Building scalable, secure, and maintainable server-side applications and APIs.' }}
                </p>
                <div class="flex flex-wrap gap-2 justify-center">
                    @if(isset($globalSettings['about_skill_2_tags']) && is_array($globalSettings['about_skill_2_tags']))
                        @foreach($globalSettings['about_skill_2_tags'] as $tag)
                            <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 text-sm rounded-full">{{ $tag }}</span>
                        @endforeach
                    @else
                        <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 text-sm rounded-full">Laravel</span>
                        <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 text-sm rounded-full">Node.js</span>
                        <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 text-sm rounded-full">PHP</span>
                        <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 text-sm rounded-full">MySQL</span>
                    @endif
                </div>
            </div>
            
            <!-- Design & UX -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">{{ $globalSettings['about_skill_3_title'] ?? 'Design & UX' }}</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    {{ $globalSettings['about_skill_3_description'] ?? 'Crafting intuitive and visually appealing designs that prioritize user experience and accessibility.' }}
                </p>
                <div class="flex flex-wrap gap-2 justify-center">
                    @if(isset($globalSettings['about_skill_3_tags']) && is_array($globalSettings['about_skill_3_tags']))
                        @foreach($globalSettings['about_skill_3_tags'] as $tag)
                            <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 text-sm rounded-full">{{ $tag }}</span>
                        @endforeach
                    @else
                        <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 text-sm rounded-full">Figma</span>
                        <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 text-sm rounded-full">Adobe XD</span>
                        <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 text-sm rounded-full">UI/UX</span>
                        <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 text-sm rounded-full">Prototyping</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-20 bg-white dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                {{ $globalSettings['about_values_title'] ?? 'Core Values' }}
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                The principles that guide my work and relationships.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $globalSettings['about_value_1_title'] ?? 'Innovation' }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    {{ $globalSettings['about_value_1_description'] ?? 'Constantly exploring new technologies and approaches to solve problems creatively.' }}
                </p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $globalSettings['about_value_2_title'] ?? 'Quality' }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    {{ $globalSettings['about_value_2_description'] ?? 'Delivering exceptional work that exceeds expectations and stands the test of time.' }}
                </p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $globalSettings['about_value_3_title'] ?? 'Collaboration' }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    {{ $globalSettings['about_value_3_description'] ?? 'Working together to achieve shared goals and create meaningful impact.' }}
                </p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $globalSettings['about_value_4_title'] ?? 'Learning' }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    {{ $globalSettings['about_value_4_description'] ?? 'Embracing continuous growth and staying curious about new possibilities.' }}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-br from-blue-600 to-purple-700 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl md:text-5xl font-bold mb-6">
            {{ $globalSettings['about_cta_title'] ?? "Let's Create Something" }}
            <br>
            <span class="text-blue-200">{{ $globalSettings['about_cta_subtitle'] ?? 'Amazing Together' }}</span>
        </h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
            {{ $globalSettings['about_cta_description'] ?? "Ready to bring your ideas to life? I'd love to hear about your project and explore how we can work together." }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact') }}" 
               class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition-colors">
                {{ $globalSettings['about_cta_button_contact'] ?? 'Start a Conversation' }}
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
            </a>
            <a href="{{ route('portfolio.index') }}" 
               class="inline-flex items-center px-8 py-4 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-blue-600 transition-all duration-200">
                {{ $globalSettings['about_cta_button_work'] ?? 'View My Work' }}
            </a>
        </div>
    </div>
</section>
@endsection