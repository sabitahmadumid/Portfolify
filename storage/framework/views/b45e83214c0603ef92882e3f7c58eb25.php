<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['comment', 'depth' => 0]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['comment', 'depth' => 0]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="comment-item <?php echo e($depth > 0 ? 'ml-8 border-l border-gray-200 dark:border-gray-700 pl-4' : ''); ?>">
    <div class="flex space-x-4 mb-4">
        <!-- Avatar -->
        <div class="flex-shrink-0">
            <?php if (isset($component)) { $__componentOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.avatar','data' => ['name' => $comment->author_display_name,'email' => $comment->author_email ?? 'anonymous@example.com','size' => 'w-10 h-10','textSize' => 'text-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($comment->author_display_name),'email' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($comment->author_email ?? 'anonymous@example.com'),'size' => 'w-10 h-10','text-size' => 'text-sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b)): ?>
<?php $attributes = $__attributesOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b; ?>
<?php unset($__attributesOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b)): ?>
<?php $component = $__componentOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b; ?>
<?php unset($__componentOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b); ?>
<?php endif; ?>
        </div>
        
        <!-- Comment Content -->
        <div class="flex-1 min-w-0">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                <!-- Comment Header -->
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center space-x-2">
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100">
                            <?php echo e($comment->author_display_name); ?>

                        </h4>
                        <time class="text-sm text-gray-500 dark:text-gray-400">
                            <?php echo e($comment->created_at->diffForHumans()); ?>

                        </time>
                    </div>
                    
                    <!-- Comment Actions -->
                    <div class="flex items-center space-x-2">
                        <button onclick="toggleReplyForm(<?php echo e($comment->id); ?>)" 
                                class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                            Reply
                        </button>
                        
                        <?php if(auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->is_admin ?? false)): ?>
                        <form action="<?php echo e(route('comments.destroy', $comment)); ?>" method="POST" class="inline" 
                              onsubmit="return confirm('Are you sure you want to delete this comment?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-sm text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-medium">
                                Delete
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Comment Content -->
                <div class="text-gray-700 dark:text-gray-300 prose prose-sm max-w-none">
                    <?php echo nl2br(e($comment->content)); ?>

                </div>
            </div>
            
            <!-- Reply Form (Hidden by default) -->
            <div id="reply-form-<?php echo e($comment->id); ?>" class="hidden mt-4">
                <form action="<?php echo e(route('comments.store', $comment->post)); ?>" method="POST" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="parent_id" value="<?php echo e($comment->id); ?>">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="reply_author_name_<?php echo e($comment->id); ?>" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Name *
                            </label>
                            <input type="text" 
                                   id="reply_author_name_<?php echo e($comment->id); ?>" 
                                   name="author_name" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                        </div>
                        
                        <div>
                            <label for="reply_author_email_<?php echo e($comment->id); ?>" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Email *
                            </label>
                            <input type="email" 
                                   id="reply_author_email_<?php echo e($comment->id); ?>" 
                                   name="author_email" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                        </div>
                    </div>
                    
                    <div>
                        <label for="reply_content_<?php echo e($comment->id); ?>" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Reply *
                        </label>
                        <textarea id="reply_content_<?php echo e($comment->id); ?>" 
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
                                onclick="toggleReplyForm(<?php echo e($comment->id); ?>)"
                                class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 font-medium">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Replies -->
    <?php if($comment->approvedReplies->count() > 0): ?>
        <div class="replies ml-4 space-y-4">
            <?php $__currentLoopData = $comment->approvedReplies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginalfe4855bb643954c83a0cbd6710da1102 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfe4855bb643954c83a0cbd6710da1102 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment','data' => ['comment' => $reply,'depth' => $depth + 1]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['comment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($reply),'depth' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($depth + 1)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfe4855bb643954c83a0cbd6710da1102)): ?>
<?php $attributes = $__attributesOriginalfe4855bb643954c83a0cbd6710da1102; ?>
<?php unset($__attributesOriginalfe4855bb643954c83a0cbd6710da1102); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfe4855bb643954c83a0cbd6710da1102)): ?>
<?php $component = $__componentOriginalfe4855bb643954c83a0cbd6710da1102; ?>
<?php unset($__componentOriginalfe4855bb643954c83a0cbd6710da1102); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div><?php /**PATH /Users/xcalibur/Herd/portfolify/resources/views/components/comment.blade.php ENDPATH**/ ?>