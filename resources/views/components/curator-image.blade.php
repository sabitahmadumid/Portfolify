@props([
    'media' => null,
    'width' => null,
    'height' => null,
    'class' => '',
    'alt' => '',
    'loading' => 'lazy'
])

@php
    $mediaItem = $media;
    
    // If media is an ID, get the media model
    if (is_numeric($media)) {
        $mediaItem = \Awcodes\Curator\Models\Media::find($media);
    }
    
    // If media is a model but not a Curator Media model, try to get the curator media
    if ($media && is_object($media) && !($media instanceof \Awcodes\Curator\Models\Media)) {
        $mediaItem = $media->featuredImage ?? null;
    }
@endphp

@if($mediaItem && $mediaItem instanceof \Awcodes\Curator\Models\Media)
    @if($mediaItem->type && Str::startsWith($mediaItem->type, 'image/'))
        <img src="{{ $mediaItem->url }}" 
             alt="{{ $alt ?: $mediaItem->alt ?: 'Image' }}"
             {{ $attributes->merge(['class' => $class]) }}
             loading="{{ $loading }}"
             @if($width) width="{{ $width }}" @endif
             @if($height) height="{{ $height }}" @endif
        />
    @else
        <!-- File type indicator for non-images -->
        <div {{ $attributes->merge(['class' => 'bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 flex items-center justify-center ' . $class]) }}>
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center mb-2 mx-auto">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ strtoupper(pathinfo($mediaItem->name, PATHINFO_EXTENSION) ?: 'FILE') }}</p>
            </div>
        </div>
    @endif
@else
    <!-- Fallback placeholder -->
    <div {{ $attributes->merge(['class' => 'bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 flex items-center justify-center ' . $class]) }}>
        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
        </div>
    </div>
@endif