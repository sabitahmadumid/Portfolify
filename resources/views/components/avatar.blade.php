@props([
    'name' => 'User',
    'email' => 'user@example.com',
    'size' => 'w-10 h-10',
    'textSize' => 'text-sm',
    'type' => 'gradient'
])

@php
    use App\Helpers\AvatarHelper;
    $avatar = AvatarHelper::generateAvatar($name, $email, $type);
@endphp

<div class="relative {{ $size }} rounded-full {{ $avatar['color'] }} flex items-center justify-center text-white {{ $textSize }} font-semibold shadow-lg overflow-hidden">
    <img src="{{ $avatar['gravatar'] }}" 
         alt="{{ $name }}"
         class="w-full h-full rounded-full object-cover absolute inset-0"
         onerror="this.style.display='none';">
    <span class="flex items-center justify-center w-full h-full">
        {{ $avatar['initials'] }}
    </span>
</div>