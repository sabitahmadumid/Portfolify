<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OptimizeResponse
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only optimize HTML responses
        if (! $response instanceof Response || ! str_contains($response->headers->get('Content-Type', ''), 'text/html')) {
            return $response;
        }

        $content = $response->getContent();

        if ($content) {
            // Minify HTML (basic implementation)
            $content = $this->minifyHtml($content);

            // Add performance headers
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('X-Frame-Options', 'DENY');
            $response->headers->set('X-XSS-Protection', '1; mode=block');

            // Add cache headers for static content
            if ($this->isStaticContent($request)) {
                $response->headers->set('Cache-Control', 'public, max-age=31536000'); // 1 year
            } else {
                $response->headers->set('Cache-Control', 'public, max-age=300'); // 5 minutes
            }

            $response->setContent($content);
        }

        return $response;
    }

    /**
     * Basic HTML minification
     */
    private function minifyHtml(string $html): string
    {
        // Preserve script and style tag contents by replacing them with placeholders
        $scriptPlaceholders = [];
        $stylePlaceholders = [];
        
        // Extract and preserve script tags
        $html = preg_replace_callback(
            '/<script[^>]*>(.*?)<\/script>/si',
            function ($matches) use (&$scriptPlaceholders) {
                $placeholder = '___SCRIPT_PLACEHOLDER_' . count($scriptPlaceholders) . '___';
                $scriptPlaceholders[$placeholder] = $matches[0];
                return $placeholder;
            },
            $html
        );
        
        // Extract and preserve style tags
        $html = preg_replace_callback(
            '/<style[^>]*>(.*?)<\/style>/si',
            function ($matches) use (&$stylePlaceholders) {
                $placeholder = '___STYLE_PLACEHOLDER_' . count($stylePlaceholders) . '___';
                $stylePlaceholders[$placeholder] = $matches[0];
                return $placeholder;
            },
            $html
        );

        // Remove HTML comments (but keep IE conditional comments)
        $html = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $html);

        // Remove extra whitespace between tags
        $html = preg_replace('/>\s+</', '><', $html);

        // Remove extra whitespace within tags (but preserve single spaces)
        $html = preg_replace('/\s+/', ' ', $html);

        // Restore script tags
        foreach ($scriptPlaceholders as $placeholder => $content) {
            $html = str_replace($placeholder, $content, $html);
        }
        
        // Restore style tags
        foreach ($stylePlaceholders as $placeholder => $content) {
            $html = str_replace($placeholder, $content, $html);
        }

        // Trim whitespace at the beginning and end
        return trim($html);
    }

    /**
     * Check if the request is for static content
     */
    private function isStaticContent(Request $request): bool
    {
        $staticExtensions = ['css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'webp', 'ico', 'woff', 'woff2', 'ttf', 'eot'];
        $path = $request->path();
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        return in_array($extension, $staticExtensions);
    }
}
