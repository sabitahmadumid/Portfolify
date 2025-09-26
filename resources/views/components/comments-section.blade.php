@props(['post', 'comments'])

<!-- Comments Section -->
<section class="py-12 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-950 rounded-2xl shadow-lg p-8">
            <!-- Comments Header -->
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    Comments ({{ $comments->count() }})
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Join the conversation and share your thoughts
                </p>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                    <p class="text-green-800 dark:text-green-300">{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                    <ul class="text-red-800 dark:text-red-300 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Comment Form -->
            @if($post->allow_comments)
            <div class="mb-8 pb-8 border-b border-gray-200 dark:border-gray-800">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    Leave a Comment
                </h4>
                
                <form action="{{ route('comments.store', $post) }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="author_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Name *
                            </label>
                            <input type="text" 
                                   id="author_name" 
                                   name="author_name" 
                                   value="{{ old('author_name') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 transition-colors">
                        </div>
                        
                        <div>
                            <label for="author_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email *
                            </label>
                            <input type="email" 
                                   id="author_email" 
                                   name="author_email" 
                                   value="{{ old('author_email') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 transition-colors">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Your email will not be published. It's used for avatar generation.
                            </p>
                        </div>
                    </div>
                    
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Comment *
                        </label>
                        <div class="relative">
                            <textarea id="content" 
                                      name="content" 
                                      rows="5" 
                                      required
                                      maxlength="1000"
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 resize-none transition-colors"
                                      placeholder="Share your thoughts..."
                                      oninput="updateCharCount(this)">{{ old('content') }}</textarea>
                            <div class="absolute bottom-3 right-3 text-xs text-gray-400" id="char-count">
                                0/1000
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <x-avatar 
                                name="Preview User" 
                                email="preview@example.com"
                                size="w-8 h-8"
                                text-size="text-xs"
                            />
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Your avatar will be generated based on your email
                            </p>
                        </div>
                        
                        <button type="submit" 
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors font-medium">
                            Post Comment
                        </button>
                    </div>
                </form>
            </div>
            @else
            <div class="mb-8 pb-8 border-b border-gray-200 dark:border-gray-800">
                <p class="text-gray-600 dark:text-gray-400 text-center py-4">
                    Comments are disabled for this post.
                </p>
            </div>
            @endif

            <!-- Comments List -->
            @if($comments->count() > 0)
                <div class="space-y-6">
                    @foreach($comments as $comment)
                        <x-comment :comment="$comment" />
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.418 8-9.849 8-1.127 0-2.211-.2-3.211-.567L3 21l1.567-4.94A8.962 8.962 0 013 12c0-4.418 4.418-8 9.849-8S21 7.582 21 12z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        No comments yet
                    </h4>
                    <p class="text-gray-600 dark:text-gray-400">
                        Be the first to share your thoughts on this post!
                    </p>
                </div>
            @endif
        </div>
    </div>
</section>

@push('scripts')
<script>
function toggleReplyForm(commentId) {
    const form = document.getElementById('reply-form-' + commentId);
    if (form.classList.contains('hidden')) {
        // Hide all other reply forms
        document.querySelectorAll('[id^="reply-form-"]').forEach(f => f.classList.add('hidden'));
        form.classList.remove('hidden');
        form.querySelector('input[name="author_name"]').focus();
    } else {
        form.classList.add('hidden');
    }
}

function updateCharCount(textarea) {
    const count = textarea.value.length;
    const counter = document.getElementById('char-count');
    counter.textContent = count + '/1000';
    
    if (count > 900) {
        counter.classList.add('text-red-500');
        counter.classList.remove('text-gray-400');
    } else {
        counter.classList.remove('text-red-500');
        counter.classList.add('text-gray-400');
    }
}

// Initialize character count on page load
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('content');
    if (textarea) {
        updateCharCount(textarea);
    }
});
</script>
@endpush