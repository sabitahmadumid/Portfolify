@props(['images' => []])

@php
    use Awcodes\Curator\Models\Media;
    
    // Convert image IDs to Media objects if needed
    $mediaImages = collect($images)->map(function($image) {
        if (is_numeric($image)) {
            return Media::find($image);
        }
        return $image;
    })->filter(); // Remove null values
@endphp

@if($mediaImages->count() > 0)
<div class="gallery-container">
    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
        @foreach($mediaImages as $index => $media)
            @if($media)
            <div class="group cursor-pointer" onclick="openLightbox({{ $index }})">
                <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300">
                    <x-curator-image 
                        :media="$media"
                        alt="{{ $media->alt ?? 'Gallery image ' . ($index + 1) }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                    />
                </div>
            </div>
            @endif
        @endforeach
    </div>

    <!-- Lightbox Modal -->
    <div id="lightbox-modal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden items-center justify-center p-4">
        <!-- Close Button -->
        <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Navigation Arrows -->
        <button onclick="previousImage()" class="absolute left-4 text-white hover:text-gray-300 z-10">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>

        <button onclick="nextImage()" class="absolute right-4 text-white hover:text-gray-300 z-10">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        <!-- Image Container -->
        <div class="max-w-4xl max-h-full flex items-center justify-center">
            <img id="lightbox-image" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
        </div>

        <!-- Image Info -->
        <div class="absolute bottom-4 left-4 right-4 text-center text-white">
            <p id="lightbox-caption" class="text-lg font-medium mb-2"></p>
            <p id="lightbox-counter" class="text-sm text-gray-300"></p>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentImageIndex = 0;
const galleryImages = @json($mediaImages->map(function($media) {
    return [
        'url' => $media ? $media->url : '',
        'alt' => $media ? ($media->alt ?? 'Gallery image') : '',
        'name' => $media ? $media->name : ''
    ];
}));

function openLightbox(index) {
    currentImageIndex = index;
    updateLightboxImage();
    const modal = document.getElementById('lightbox-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    const modal = document.getElementById('lightbox-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
}

function nextImage() {
    currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
    updateLightboxImage();
}

function previousImage() {
    currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
    updateLightboxImage();
}

function updateLightboxImage() {
    const image = galleryImages[currentImageIndex];
    if (image) {
        document.getElementById('lightbox-image').src = image.url;
        document.getElementById('lightbox-image').alt = image.alt;
        document.getElementById('lightbox-caption').textContent = image.alt || 'Gallery Image';
        document.getElementById('lightbox-counter').textContent = `${currentImageIndex + 1} of ${galleryImages.length}`;
    }
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('lightbox-modal');
    if (!modal.classList.contains('hidden')) {
        switch(e.key) {
            case 'Escape':
                closeLightbox();
                break;
            case 'ArrowLeft':
                previousImage();
                break;
            case 'ArrowRight':
                nextImage();
                break;
        }
    }
});

// Close lightbox when clicking outside the image
document.getElementById('lightbox-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLightbox();
    }
});
</script>
@endpush
@endif