<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PageView;

class TrackPageView
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track GET requests
        if ($request->method() !== 'GET') {
            return $response;
        }

        // Skip admin routes
        if ($request->is('admin/*') || $request->is('qTnzV62SjDYBsPaI/*')) {
            return $response;
        }

        // Skip API routes
        if ($request->is('api/*')) {
            return $response;
        }

        // Track page view
        try {
            PageView::create([
                'page_path' => $request->path(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'referer' => $request->header('referer'),
                'language' => app()->getLocale(),
                'viewed_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Silently fail if tracking fails
            \Log::error('Page view tracking failed: ' . $e->getMessage());
        }

        return $response;
    }
}
