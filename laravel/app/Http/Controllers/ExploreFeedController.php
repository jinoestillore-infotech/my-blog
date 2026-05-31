<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
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

    public function index(Request $request)
    {
        $currentUser = Auth::user();
        $selectedTag = $request->query('tag');

        // 1. Fetch published posts with filters applied
        $postsQuery = Post::where('status', 'published')
            ->with('user')
            ->withCount('likes');

        // IF a tag parameter is present in the URL, filter the posts table
        if (!empty($selectedTag)) {
            $postsQuery->whereRaw(
                "FIND_IN_SET(?, REPLACE(tags, ', ', ','))",
                [$selectedTag]
            );
        }

        $posts = $postsQuery
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->cursorPaginate(4)
            ->withQueryString(); // Keeps the ?tag=... parameter intact during pagination links!

        // 2. Dynamic "Who to Follow"
        // Grab IDs of users the current author is already following
        $alreadyFollowingIds = $currentUser->following()->pluck('user_id')->toArray();

        // 3. Query up to 5 registered users who are NOT the current user AND NOT already followed
        $suggestedUsers = User::where('id', '!=', $currentUser->id)
            ->whereNotIn('id', $alreadyFollowingIds)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        // 4. Dynamic "Trending Topics" Algorithm (Our Base Rules)
        // Retrieve tags, views, and creation dates of posts published in the last 30 days
        $recentPosts = Post::where('status', 'published')
            ->whereNotNull('tags')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->get(['tags', 'views', 'created_at']);

        $tagScores = [];

        foreach ($recentPosts as $post) {
            // Split comma-separated string tags and trim whitespace
            $tagsArray = array_filter(array_map('trim', explode(',', $post->tags)));

            // Calculate Freshness Multiplier based on age of the post
            $daysOld = Carbon::parse($post->created_at)->diffInDays(Carbon::now());
            if ($daysOld <= 3) {
                $freshnessMultiplier = 2.0; // High weight for brand new stories
            } elseif ($daysOld <= 7) {
                $freshnessMultiplier = 1.5;
            } else {
                $freshnessMultiplier = 1.0; // Standard weight for older posts
            }

            // Calculate the score contribution for this post: (1 base point + views) * freshness
            $postScoreContribution = (1 + $post->views) * $freshnessMultiplier;

            foreach ($tagsArray as $tag) {
                // Normalize casing to prevent duplication (e.g. "laravel" and "Laravel")
                $normalizedTag = ucwords(strtolower($tag));

                if (!empty($normalizedTag)) {
                    if (!isset($tagScores[$normalizedTag])) {
                        $tagScores[$normalizedTag] = 0;
                    }
                    // Accumulate score contribution
                    $tagScores[$normalizedTag] += $postScoreContribution;
                }
            }
        }

        // Sort tags by score high to low, preserving keys
        arsort($tagScores);

        // Take the top 5 trending tags to display in our view widget
        $trendingTags = array_slice(array_keys($tagScores), 0, 5);
        return view('feed.index', compact('posts', 'suggestedUsers', 'trendingTags'));
    }
}