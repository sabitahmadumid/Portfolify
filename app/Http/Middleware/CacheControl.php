<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class CacheControl
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $duration = '3600'): Response
    {
        $response = $next($request);

        // Don't cache if user is authenticated (admin panel)
        if ($request->user()) {
            return $response;
        }

        // Don't cache POST requests or other non-GET requests
        if (! $request->isMethod('GET')) {
            return $response;
        }

        // Don't cache if there are errors
        if ($response->getStatusCode() !== 200) {
            return $response;
        }

        // Set cache headers based on route
        $cacheTime = $this->getCacheTimeForRoute($request, (int) $duration);

        return $response->withHeaders([
            'Cache-Control' => "public, max-age={$cacheTime}",
            'Expires' => gmdate('D, d M Y H:i:s', time() + $cacheTime).' GMT',
            'Last-Modified' => gmdate('D, d M Y H:i:s', time()).' GMT',
            'ETag' => md5($response->getContent()),
        ]);
    }

    /**
     * Get cache time based on route type
     */
    private function getCacheTimeForRoute(Request $request, int $default): int
    {
        $path = $request->path();

        // Static assets - cache for 1 year
        if (preg_match('/\.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$/', $path)) {
            return 31536000; // 1 year
        }

        // Homepage - cache for 15 minutes
        if ($path === '/' || $path === 'home') {
            return 900; // 15 minutes
        }

        // Blog posts - cache for 1 hour
        if (str_starts_with($path, 'blog/') && ! str_contains($path, '?')) {
            return 3600; // 1 hour
        }

        // Blog listings - cache for 30 minutes
        if ($path === 'blog' || str_starts_with($path, 'blog?')) {
            return 1800; // 30 minutes
        }

        // About page - cache for 6 hours
        if ($path === 'about') {
            return 21600; // 6 hours
        }

        // Contact page - cache for 1 hour
        if ($path === 'contact') {
            return 3600; // 1 hour
        }

        // API endpoints - shorter cache
        if (str_starts_with($path, 'api/')) {
            return 300; // 5 minutes
        }

        return $default;
    }
}
