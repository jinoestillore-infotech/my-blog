<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExploreFeedController extends Controller
{
    /**
     * Create a new controller instance.
     * Ensure only authenticated users can look at the active explore feed feed.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Handle the incoming request for the social feed dashboard.
     *
     * STREAMING_CHUNK: Fetching published community stories for the authenticated newsfeed...
     */
    public function index()
    {
        // Eager load 'user' and count 'likes' directly in database to solve N+1 performance bottlenecks
        $posts = Post::with('user')->withCount('likes')->published()->latest()->paginate(10);
        
        return view('feed.index', compact('posts'));
    }
}