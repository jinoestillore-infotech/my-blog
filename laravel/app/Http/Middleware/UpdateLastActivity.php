<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastActivity
{
    /**
     * Handle an incoming request.
     * Updates the authenticated user's last activity timestamp to track live session metrics.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Only update database once every 60 seconds to avoid unnecessary queries
            if (is_null($user->last_activity_at) || $user->last_activity_at->diffInSeconds(now()) > 60) {
                // Temporarily disable timestamp updates so updated_at is preserved for posts/actions
                $user->timestamps = false;
                $user->last_activity_at = now();
                $user->save();
            }
        }

        return $next($request);
    }
}