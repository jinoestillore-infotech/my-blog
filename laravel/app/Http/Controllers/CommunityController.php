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
        $this->middleware('auth');
    }

    /**
     * Display the dynamic community directory sorted by popularity (followers count).
     */
    // public function index(Request $request)
    // {
    //     $search = $request->query('search');

    //     // Start a query count on the followers relationship
    //     $query = User::withCount('followers')
    //         ->where('id', '!=', Auth::id()); // Exclude the current logged-in user

    //     // Handle the live search input from the directory search bar
    //     if (!empty($search)) {
    //         $query->where(function($q) use ($search) {
    //             $q->where('name', 'LIKE', "%{$search}%")
    //               ->orWhere('username', 'LIKE', "%{$search}%")
    //               ->orWhere('bio', 'LIKE', "%{$search}%");
    //         });
    //     }

    //     // Sort by followers count (popularity) and paginate
    //     $writers = $query->orderBy('followers_count', 'desc')
    //         ->paginate(9)
    //         ->withQueryString();

    //     return view('community', compact('writers', 'search'));
    // }

    /**
     * Display the dedicated Popular Writers ranking workspace.
     *
     * This acts as a distinct, specialized page focused on follower statistics.
     */
    public function popular()
    {
        // Fetch users sorted strictly by followers count, excluding the current user
        $popularWriters = User::withCount('followers')
            ->orderBy('followers_count', 'desc')
            ->paginate(12);

        // Updated to resolve to the feed subdirectory
        return view('feed.popular', compact('popularWriters'));
    }
}