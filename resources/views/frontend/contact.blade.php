@extends('frontend.layouts.app')

@section('title', 'Contact - Let\'s Work Together')
@section('description', 'Ready to start a project? Get in touch and let\'s create something amazing together.')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-950 dark:to-gray-900">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 right-1/4 w-64 h-64 bg-blue-200/20 dark:bg-blue-900/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 left-1/4 w-96 h-96 bg-purple-200/20 dark:bg-purple-900/10 rounded-full blur-3xl"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-gray-900 dark:text-gray-100 mb-6">
            Let's <span class="gradient-text">Connect</span>
        </h1>
        <p class="text-lg sm:text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto mb-8">
            Ready to bring your ideas to life? I'd love to hear about your project and explore how we can work together 
            to create something amazing.
        </p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-20 bg-white dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">
            <!-- Contact Form -->
            <div class="order-2 lg:order-1">
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-6 lg:p-8">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">Send Me a Message</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-8">
                        Fill out the form below and I'll get back to you as soon as possible. Let's discuss your project!
                    </p>
                    
                    <form class="space-y-6" method="POST" action="#" id="contact-form">
                        @csrf
                        
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Full Name *
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   required
                                   class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                                   placeholder="Your full name">
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email Address *
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   required
                                   class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                                   placeholder="your.email@example.com">
                        </div>
                        
                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Subject *
                            </label>
                            <select id="subject" 
                                    name="subject" 
                                    required
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-gray-100">
                                <option value="">Select a subject</option>
                                <option value="project">New Project Inquiry</option>
                                <option value="collaboration">Collaboration Opportunity</option>
                                <option value="consultation">Consultation Request</option>
                                <option value="support">Technical Support</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <!-- Budget (Optional) -->
                        <div>
                            <label for="budget" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Project Budget (Optional)
                            </label>
                            <select id="budget" 
                                    name="budget"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-gray-100">
                                <option value="">Select budget range</option>
                                <option value="under-5k">Under $5,000</option>
                                <option value="5k-10k">$5,000 - $10,000</option>
                                <option value="10k-25k">$10,000 - $25,000</option>
                                <option value="25k-50k">$25,000 - $50,000</option>
                                <option value="50k-plus">$50,000+</option>
                                <option value="discuss">Let's discuss</option>
                            </select>
                        </div>
                        
                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Message *
                            </label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="6" 
                                      required
                                      class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 resize-none"
                                      placeholder="Tell me about your project, goals, timeline, and any specific requirements..."></textarea>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full btn-primary justify-center py-4"
                                id="submit-btn">
                            <span id="submit-text">Send Message</span>
                            <svg id="submit-icon" class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            <svg id="loading-icon" class="ml-2 w-5 h-5 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                        
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            * Required fields. I typically respond within 24 hours.
                        </p>
                    </form>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="order-1 lg:order-2 space-y-6 lg:space-y-8">
                <!-- Get in Touch -->
                <div class="bg-gradient-to-br from-blue-600 to-purple-700 rounded-2xl p-6 lg:p-8 text-white">
                    <h3 class="text-xl lg:text-2xl font-bold mb-4">Get in Touch</h3>
                    <p class="text-blue-100 mb-6">
                        I'm always excited to discuss new projects and opportunities. 
                        Whether you have a specific idea in mind or just want to explore possibilities, 
                        let's start a conversation.
                    </p>
                    
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold">Email</p>
                                <p class="text-blue-100">hello@portfolify.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold">Location</p>
                                <p class="text-blue-100">Available Worldwide</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold">Response Time</p>
                                <p class="text-blue-100">Within 24 hours</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Services -->
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 lg:p-8">
                    <h3 class="text-xl lg:text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4 lg:mb-6">Services I Offer</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-blue-600 rounded-full mr-4"></div>
                            <span class="text-gray-700 dark:text-gray-300">Web Application Development</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-blue-600 rounded-full mr-4"></div>
                            <span class="text-gray-700 dark:text-gray-300">E-commerce Solutions</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-blue-600 rounded-full mr-4"></div>
                            <span class="text-gray-700 dark:text-gray-300">API Development & Integration</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-blue-600 rounded-full mr-4"></div>
                            <span class="text-gray-700 dark:text-gray-300">UI/UX Design</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-blue-600 rounded-full mr-4"></div>
                            <span class="text-gray-700 dark:text-gray-300">Technical Consulting</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-blue-600 rounded-full mr-4"></div>
                            <span class="text-gray-700 dark:text-gray-300">Code Review & Optimization</span>
                        </div>
                    </div>
                </div>
                
                <!-- Social Links -->
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 lg:p-8">
                    <h3 class="text-xl lg:text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4 lg:mb-6">Connect With Me</h3>
                    <div class="flex flex-wrap gap-3 sm:gap-4">
                        <a href="#" 
                           class="w-12 h-12 bg-blue-600 hover:bg-blue-700 rounded-lg flex items-center justify-center text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" 
                           class="w-12 h-12 bg-blue-700 hover:bg-blue-800 rounded-lg flex items-center justify-center text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="#" 
                           class="w-12 h-12 bg-gray-800 hover:bg-gray-900 rounded-lg flex items-center justify-center text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.374 0 0 5.373 0 12 0 17.302 3.438 21.8 8.207 23.387c.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>
                            </svg>
                        </a>
                        <a href="#" 
                           class="w-12 h-12 bg-pink-600 hover:bg-pink-700 rounded-lg flex items-center justify-center text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.347-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.161-1.499-.698-2.436-2.888-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.357-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 lg:mb-16">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                Frequently Asked <span class="gradient-text">Questions</span>
            </h2>
            <p class="text-lg lg:text-xl text-gray-600 dark:text-gray-400">
                Quick answers to common questions about working together.
            </p>
        </div>
        
        <div class="space-y-4 lg:space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 lg:p-8 shadow-lg">
                <h3 class="text-lg lg:text-xl font-bold text-gray-900 dark:text-gray-100 mb-3">What's your typical project timeline?</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Project timelines vary depending on scope and complexity. A simple website might take 2-4 weeks, 
                    while a complex web application could take 2-6 months. I always provide detailed timelines during our initial consultation.
                </p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 lg:p-8 shadow-lg">
                <h3 class="text-lg lg:text-xl font-bold text-gray-900 dark:text-gray-100 mb-3">Do you work with international clients?</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Absolutely! I have experience working with clients from around the world. I'm comfortable working 
                    across different time zones and use modern communication tools to ensure smooth collaboration.
                </p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 lg:p-8 shadow-lg">
                <h3 class="text-lg lg:text-xl font-bold text-gray-900 dark:text-gray-100 mb-3">What's included in your services?</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    I offer end-to-end solutions including planning, design, development, testing, deployment, and ongoing support. 
                    Each project is tailored to your specific needs and requirements.
                </p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 lg:p-8 shadow-lg">
                <h3 class="text-lg lg:text-xl font-bold text-gray-900 dark:text-gray-100 mb-3">How do you handle project communication?</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    I believe in transparent, regular communication. I provide weekly progress updates, maintain a project dashboard, 
                    and I'm always available for questions via email, Slack, or scheduled calls.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.getElementById('contact-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form elements
        const submitBtn = document.getElementById('submit-btn');
        const submitText = document.getElementById('submit-text');
        const submitIcon = document.getElementById('submit-icon');
        const loadingIcon = document.getElementById('loading-icon');
        
        // Show loading state
        submitBtn.disabled = true;
        submitText.textContent = 'Sending...';
        submitIcon.classList.add('hidden');
        loadingIcon.classList.remove('hidden');
        
        // Simulate form submission (replace with actual form submission logic)
        setTimeout(() => {
            // Show success state
            submitText.textContent = 'Message Sent!';
            loadingIcon.classList.add('hidden');
            submitIcon.classList.remove('hidden');
            submitBtn.classList.remove('btn-primary');
            submitBtn.classList.add('bg-green-600', 'hover:bg-green-700');
            
            // Reset form
            document.getElementById('contact-form').reset();
            
            // Reset button after 3 seconds
            setTimeout(() => {
                submitBtn.disabled = false;
                submitText.textContent = 'Send Message';
                submitBtn.classList.add('btn-primary');
                submitBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
            }, 3000);
        }, 2000);
    });
</script>
@endpush