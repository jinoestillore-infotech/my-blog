<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
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
    // public function index()
    // {
    //     // Eager load 'user' and count 'likes' directly in database to solve N+1 performance bottlenecks
    //     $posts = Post::with('user')->withCount('likes')->published()->latest()->paginate(10);
        
    //     return view('feed.index', compact('posts'));
    // }

    public function index()
    {
        $currentUser = Auth::user();

        // 1. Fetch paginated published posts with authors eager loaded
        $posts = Post::where('status', 'published')
            ->withCount(['user', 'likes'])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // 2. Dynamic "Who to Follow"
        // Grab IDs of users the current author is already following
        $alreadyFollowingIds = $currentUser->following()->pluck('user_id')->toArray();

        // Query up to 3 registered users who are NOT the current user AND NOT already followed
        $suggestedUsers = User::where('id', '!=', $currentUser->id)
            ->whereNotIn('id', $alreadyFollowingIds)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('feed.index', compact('posts', 'suggestedUsers'));
    }
}