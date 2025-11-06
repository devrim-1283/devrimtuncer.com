<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from route parameter
        $locale = $request->route('locale');
        
        // If locale is in route, use it
        if ($locale && in_array($locale, ['tr', 'en'])) {
            app()->setLocale($locale);
        } else {
            // Default to Turkish if no language specified
            app()->setLocale('tr');
        }
        
        return $next($request);
    }
}
