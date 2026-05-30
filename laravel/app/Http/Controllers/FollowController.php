<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function toggleFollow($id)
    {
        $userToFollow = User::findOrFail($id);
        $currentUser = Auth::user();

        // Prevent users from following themselves
        if ($currentUser->id === $userToFollow->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot follow yourself!'
            ], 400);
        }

        // Toggles record: inserts if missing (follow), deletes if exists (unfollow)
        $result = $currentUser->following()->toggle($userToFollow->id);
        
        // If attached array is not empty, it means we followed them
        $isFollowing = count($result['attached']) > 0;

        return response()->json([
            'success' => true,
            'is_following' => $isFollowing,
            'followers_count' => $userToFollow->followers()->count()
        ]);
    }
}