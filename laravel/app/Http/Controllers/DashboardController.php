<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     * 
     * Ensures only authenticated users can access dashboard stats.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the dynamic writer dashboard with real user stats.
     *
     * STREAMING_CHUNK: Querying database for user posts, views, and drafts...
     */
    public function index()
    {
        $user = Auth::user();
        
        // Count only the logged-in user's published stories
        $publishedCount = $user->posts()->published()->count();
        
        // Sum up total views across all posts owned by this user
        $totalViews = $user->posts()->sum('views');
        
        // Dynamically count followers and following relationships
        $followersCount = $user->followers()->count();
        $followingCount = $user->following()->count();

        // Get the latest 3 posts (draft or published) to show in the quick list
        $recentPosts = $user->posts()->latest()->take(4)->get();

        return view('pages.index', compact('publishedCount', 'totalViews', 'recentPosts', 'followersCount', 'followingCount'));
    }
}