<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     * Restrict active reporting exclusively to logged-in community members.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created report request in the database.
     */
    public function store(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $currentUser = Auth::user();

        // Security barrier: Prevent authors from reporting their own stories
        if ($post->user_id === $currentUser->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot report your own story!'
            ], 400);
        }

        // Security barrier: Verify if this user has already reported this specific post
        $duplicateCheck = Report::where('user_id', $currentUser->id)
            ->where('post_id', $post->id)
            ->exists();

        if ($duplicateCheck) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reported this story. Our administration team is currently reviewing it.'
            ], 422);
        }

        // Validate reason and optional details payload
        $request->validate([
            'reason' => 'required|string|max:255',
            'details' => 'nullable|string|max:1000',
        ]);

        // Secure insertion
        Report::create([
            'user_id' => $currentUser->id,
            'post_id' => $post->id,
            'reason' => $request->reason,
            'details' => $request->details,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you. Your report has been securely submitted. Our moderators will review this content immediately.'
        ]);
    }
}