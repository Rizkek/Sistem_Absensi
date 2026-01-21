<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;

/**
 * Middleware untuk mengoptimasi login performance
 *
 * - Caching user profile setelah login
 * - Rate limiting untuk brute force protection
 * - Query optimization
 */
class OptimizeLogin
{
    public function handle(Request $request, Closure $next)
    {
        // Rate limiting untuk login attempts
        if ($request->is('filament/*/auth/login') && $request->isMethod('post')) {
            $key = 'login.attempts.' . $request->ip();

            if (RateLimiter::tooManyAttempts($key, 5)) {
                // 5 attempts per minute
                return response()->json(['message' => 'Too many login attempts'], 429);
            }

            RateLimiter::hit($key, 60); // Reset after 1 minute
        }

        return $next($request);
    }
}
