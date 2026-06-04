<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     * Restricts routes exclusively to administrators or moderators.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Please authenticate to access the administration portal.']);
        }

        $user = Auth::user();

        // Enforce role authorization boundaries
        if ($user->role !== 'admin' && $user->role !== 'moderator') {
            Auth::logout();
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Access Denied: You do not possess administrative permissions.']);
        }

        return $next($request);
    }
}