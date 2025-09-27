<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class OptimizeAssets extends Command
{
    protected $signature = 'optimize:assets {--force : Force optimization even if files exist}';

    protected $description = 'Optimize application assets for production performance';

    public function handle(): int
    {
        $this->info('Starting asset optimization...');

        // Clear old assets if force flag is used
        if ($this->option('force')) {
            $this->clearOldAssets();
        }

        // Build production assets
        $this->buildAssets();

        // Optimize images (if needed)
        $this->optimizeImages();

        // Generate service worker (if applicable)
        $this->generateServiceWorker();

        $this->info('Asset optimization completed successfully!');

        return Command::SUCCESS;
    }

    private function clearOldAssets(): void
    {
        $this->info('Clearing old assets...');

        $publicBuild = public_path('build');
        if (File::exists($publicBuild)) {
            File::deleteDirectory($publicBuild);
            $this->line('- Cleared build directory');
        }

        // Clear CSS and JS from Filament
        $filamentPaths = [
            public_path('css/filament'),
            public_path('js/filament'),
        ];

        foreach ($filamentPaths as $path) {
            if (File::exists($path)) {
                File::deleteDirectory($path);
                $this->line("- Cleared {$path}");
            }
        }
    }

    private function buildAssets(): void
    {
        $this->info('Building production assets...');

        // Build with Vite
        $result = $this->call('exec', [
            'command' => 'npm run build',
        ]);

        if ($result === 0) {
            $this->line('- Assets built successfully');
        } else {
            $this->error('- Asset build failed');
        }
    }

    private function optimizeImages(): void
    {
        $this->info('Checking for image optimization opportunities...');

        $publicImages = public_path('images');
        $storageImages = storage_path('app/public/images');

        $paths = array_filter([$publicImages, $storageImages], function ($path) {
            return File::exists($path);
        });

        if (empty($paths)) {
            $this->line('- No image directories found to optimize');

            return;
        }

        foreach ($paths as $path) {
            $images = File::glob($path.'/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
            $this->line('- Found '.count($images).' images in '.basename($path));
        }

        $this->line('- Consider using WebP format for better compression');
        $this->line('- Consider lazy loading for images below the fold');
    }

    private function generateServiceWorker(): void
    {
        $this->info('Generating service worker cache manifest...');

        $buildManifest = public_path('build/manifest.json');

        if (! File::exists($buildManifest)) {
            $this->line('- No build manifest found, skipping service worker');

            return;
        }

        $manifest = json_decode(File::get($buildManifest), true);
        $assets = array_column($manifest, 'file');

        $serviceWorkerContent = $this->generateServiceWorkerContent($assets);

        File::put(public_path('sw.js'), $serviceWorkerContent);
        $this->line('- Service worker generated with '.count($assets).' cached assets');
    }

    private function generateServiceWorkerContent(array $assets): string
    {
        $cacheVersion = 'v'.time();
        $assetList = json_encode(array_map(fn ($asset) => '/build/'.$asset, $assets));

        return <<<JS
const CACHE_VERSION = '{$cacheVersion}';
const CACHE_NAME = 'portfolify-' + CACHE_VERSION;
const ASSETS_TO_CACHE = {$assetList};

// Install event - cache assets
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => cache.addAll(ASSETS_TO_CACHE))
            .then(() => self.skipWaiting())
    );
});

// Activate event - clean old caches
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName.startsWith('portfolify-') && cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

// Fetch event - serve from cache, fallback to network
self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request)
            .then((response) => {
                return response || fetch(event.request);
            })
    );
});
JS;
    }
}
