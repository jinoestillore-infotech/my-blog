<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    /**
     * Create a new controller instance.
     * Ensure only logged-in writers can browse the directory.
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Display the dynamic community directory sorted by popularity (followers count).
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        // Start a query count on the followers relationship
        $query = User::withCount('followers');

        // Handle the live search input from the directory search bar
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('username', 'LIKE', "%{$search}%")
                  ->orWhere('bio', 'LIKE', "%{$search}%");
            });
        }

        // Sort by followers count (popularity) and paginate
        $writers = $query->orderBy('followers_count', 'desc')
            ->paginate(9)
            ->withQueryString();

        $followingIds = Auth::check()
            ? Auth::user()->following()->pluck('users.id')->flip()
            : collect();

        return view('community', compact('writers', 'search', 'followingIds'));
    }

    /**
     * Display the dedicated Popular Writers ranking workspace.
     */
    public function popular()
    {
        // OPTIMIZED: Limit results strictly to the Top 10 writers (no pagination needed)
        $popularWriters = User::withCount('followers')
            ->orderBy('followers_count', 'desc')
            ->limit(10)
            ->get();

        // OPTIMIZED: Pre-fetch following keys for the Top 10 only to protect query limits
        $writerIds = $popularWriters->pluck('id')->toArray();
        $followedIds = Auth::check()
            ? Auth::user()->following()->whereIn('user_id', $writerIds)->pluck('user_id')->flip()->toArray()
            : [];

        // Updated to resolve to the feed subdirectory
        return view('feed.popular', compact('popularWriters', 'followedIds'));
    }

    /**
     * Dedicated Facebook "Add Friends" style search and writer discovery engine.
     */
    public function findWriters(Request $request)
    {
        $search = $request->query('search');
        $currentUser = Auth::user();

        // Query all registered authors except the current authenticated user
        $query = User::withCount('followers')
            ->where('id', '!=', $currentUser->id);

        // Filter results dynamically if a search query is active
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('username', 'LIKE', "%{$search}%")
                  ->orWhere('bio', 'LIKE', "%{$search}%");
            });
        }

        // Display results ordered alphabetically (or by dynamic ranking)
        $writers = $query->orderBy('name', 'asc')
            ->paginate(12)
            ->withQueryString();

        // OPTIMIZED: Pre-fetch following IDs matching page results to prevent N+1 view queries
        $writerIds = $writers->pluck('id')->toArray();
        $followedIds = Auth::check()
            ? Auth::user()->following()->whereIn('user_id', $writerIds)->pluck('user_id')->flip()->toArray()
            : [];

        return view('feed.search_writers', compact('writers', 'search', 'followedIds'));
    }
}