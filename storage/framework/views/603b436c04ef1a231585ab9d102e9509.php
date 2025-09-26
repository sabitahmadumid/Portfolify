<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name' => 'User',
    'email' => 'user@example.com',
    'size' => 'w-10 h-10',
    'textSize' => 'text-sm',
    'type' => 'gradient'
]));

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

foreach (array_filter(([
    'name' => 'User',
    'email' => 'user@example.com',
    'size' => 'w-10 h-10',
    'textSize' => 'text-sm',
    'type' => 'gradient'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    use App\Helpers\AvatarHelper;
    $avatar = AvatarHelper::generateAvatar($name, $email, $type);
?>

<div class="relative <?php echo e($size); ?> rounded-full <?php echo e($avatar['color']); ?> flex items-center justify-center text-white <?php echo e($textSize); ?> font-semibold shadow-lg overflow-hidden">
    <img src="<?php echo e($avatar['gravatar']); ?>" 
         alt="<?php echo e($name); ?>"
         class="w-full h-full rounded-full object-cover absolute inset-0"
         onerror="this.style.display='none';">
    <span class="flex items-center justify-center w-full h-full">
        <?php echo e($avatar['initials']); ?>

    </span>
</div><?php /**PATH /Users/xcalibur/Herd/portfolify/resources/views/components/avatar.blade.php ENDPATH**/ ?>