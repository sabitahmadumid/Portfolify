@props(['comment', 'depth' => 0])

<div class="comment-item {{ $depth > 0 ? 'ml-8 border-l border-gray-200 dark:border-gray-700 pl-4' : '' }}">
    <div class="flex space-x-4 mb-4">
        <!-- Avatar -->
        <div class="flex-shrink-0">
            <x-avatar 
                :name="$comment->author_display_name" 
                :email="$comment->author_email ?? 'anonymous@example.com'"
                size="w-10 h-10"
                text-size="text-sm"
            />
        </div>
        
        <!-- Comment Content -->
        <div class="flex-1 min-w-0">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                <!-- Comment Header -->
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center space-x-2">
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100">
                            {{ $comment->author_display_name }}
                        </h4>
                        <time class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $comment->created_at->diffForHumans() }}
                        </time>
                    </div>
                    
                    <!-- Comment Actions -->
                    <div class="flex items-center space-x-2">
                        <button onclick="toggleReplyForm({{ $comment->id }})" 
                                class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                            Reply
                        </button>
                        
                        @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->is_admin ?? false))
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline" 
                              onsubmit="return confirm('Are you sure you want to delete this comment?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-medium">
                                Delete
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                
                <!-- Comment Content -->
                <div class="text-gray-700 dark:text-gray-300 prose prose-sm max-w-none">
                    {!! nl2br(e($comment->content)) !!}
                </div>
            </div>
            
            <!-- Reply Form (Hidden by default) -->
            <div id="reply-form-{{ $comment->id }}" class="hidden mt-4">
                <form action="{{ route('comments.store', $comment->post) }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="reply_author_name_{{ $comment->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Name *
                            </label>
                            <input type="text" 
                                   id="reply_author_name_{{ $comment->id }}" 
                                   name="author_name" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                        </div>
                        
                        <div>
                            <label for="reply_author_email_{{ $comment->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Email *
                            </label>
                            <input type="email" 
                                   id="reply_author_email_{{ $comment->id }}" 
                                   name="author_email" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                        </div>
                    </div>
                    
                    <div>
                        <label for="reply_content_{{ $comment->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Reply *
                        </label>
                        <textarea id="reply_content_{{ $comment->id }}" 
                                  name="content" 
                                  rows="3" 
                                  required
                                  maxlength="1000"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 resize-none"
                                  placeholder="Write your reply..."></textarea>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors font-medium">
                            Post Reply
                        </button>
                        <button type="button" 
                                onclick="toggleReplyForm({{ $comment->id }})"
                                class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 font-medium">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Replies -->
    @if($comment->approvedReplies->count() > 0)
        <div class="replies ml-4 space-y-4">
            @foreach($comment->approvedReplies as $reply)
                <x-comment :comment="$reply" :depth="$depth + 1" />
            @endforeach
        </div>
    @endif
</div>