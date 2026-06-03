<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     * Ensure only logged-in writers can edit profiles.
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Display a specific writer's public profile containing all published posts.
     */
    public function show($username)
    {
        // Fetch user based on unique username
        $user = User::where('username', $username)
            ->withCount(['followers', 'following'])
            ->firstOrFail();

        // Paginate user's active published articles
        $posts = $user->posts()
            ->published()
            ->latest()
            ->paginate(6);

        return view('profile.show', compact('user', 'posts'));
    }

    /**
     * Show the profile edit form.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate the profile request parameters
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:255',
                'alpha_num',
                Rule::unique('users')->ignore($user->id),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'bio' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        // Process avatar upload directly to the public folder
        if ($request->hasFile('avatar')) {
            // Safely delete the old avatar file from public path if it exists
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                @unlink(public_path($user->avatar));
            }

            $image = $request->file('avatar');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Move file directly to public/images/avatars/
            $image->move(public_path('images/avatars'), $imageName);
            $user->avatar = 'images/avatars/' . $imageName;
        }

        // Fill remaining database fields
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->bio = $request->bio;
        $user->save();

        return redirect()->route('profile.show', $user->username)->with('success', 'Your profile was updated successfully!');
    }
}