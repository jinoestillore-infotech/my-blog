<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * Show the dedicated Admin Login View.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role === 'admin' || $role === 'moderator') {
                return redirect()->route('admin.dashboard');
            }
        }
        return view('admin.login');
    }

    /**
     * Authenticate administrative personnel.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Intercept non-admin/moderator users early to prevent dashboard leakage
            if ($user->role !== 'admin' && $user->role !== 'moderator') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Access Denied: These credentials do not correspond to an administrator account.'
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Authentication completed successfully. Welcome, Master.');
        }

        return back()->withErrors([
            'email' => 'The provided security credentials do not match our database directories.',
        ])->onlyInput('email');
    }

    /**
     * Terminate the administrative session.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Portal connection terminated safely.');
    }
}