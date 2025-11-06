<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;
use App\Models\Message;

class RateLimitMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only apply to message submission routes
        if (!$request->is('*/contact') && !$request->is('*/message')) {
            return $next($request);
        }

        $ipAddress = $request->ip();
        $limit = config('app.message_rate_limit', 5);
        $period = config('app.message_rate_period', 3600); // 1 hour in seconds

        // Check cache for rate limit
        $key = 'message_rate_limit:' . $ipAddress;
        $count = Cache::get($key, 0);

        if ($count >= $limit) {
            return response()->json([
                'error' => 'Too many messages. Please try again later.',
                'message' => __('messages.rate_limit_exceeded')
            ], 429);
        }

        // Increment counter
        Cache::put($key, $count + 1, now()->addSeconds($period));

        $response = $next($request);

        // If message was successfully created, increment the counter
        if ($response->getStatusCode() === 200 || $response->getStatusCode() === 201) {
            Cache::increment($key);
        }

        return $response;
    }
}
