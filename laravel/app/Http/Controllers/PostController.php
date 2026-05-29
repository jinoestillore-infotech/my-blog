<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        // Require login for writing, saving, editing, and deleting posts
        $this->middleware('auth')->except(['show', 'publicIndex']);
    }

    /**
     * Show the form for creating a new blog post.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created blog post in the database.
     */
    public function store(Request $request)
    {
        // Validate incoming post data
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        // Automatically generate an SEO-friendly URL slug from the title
        $slug = Str::slug($request->title);
        
        // Ensure slug uniqueness inside the posts table
        $originalSlug = $slug;
        $count = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        // Handle image upload if provided
        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('featured_images', 'public');
        }

        // Create the post in the database attached to the logged-in user
        Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'excerpt' => $request->excerpt ?? Str::limit(strip_tags($request->content), 150),
            'featured_image' => $imagePath,
            'status' => $request->status,
        ]);

        return redirect()->route('dashboard')->with('success', 'Your story was saved successfully!');
    }

    /**
     * Display the specified blog post to readers.
     */
    public function show($slug)
    {
        // Find the published post by its SEO slug or fail with a 404 error page
        $post = Post::where('slug', $slug)->published()->firstOrFail();

        // Safely increment the read counts on visit
        $post->increment('views');

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing an existing post.
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        // Security check: Make sure the logged-in user is actually the author of this post
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action. You do not own this post.');
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified post in the database.
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        // Re-generate slug if title has changed
        if ($request->title !== $post->title) {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $count = 1;
            while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
            $post->slug = $slug;
        }

        // Update image if a new one is uploaded
        if ($request->hasFile('featured_image')) {
            $post->featured_image = $request->file('featured_image')->store('featured_images', 'public');
        }

        $post->title = $request->title;
        $post->content = $request->content;
        $post->excerpt = $request->excerpt ?? Str::limit(strip_tags($request->content), 150);
        $post->status = $request->status;
        $post->save();

        return redirect()->route('dashboard')->with('success', 'Your story has been updated!');
    }

    /**
     * Remove the specified post from the database.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $post->delete();

        return redirect()->route('dashboard')->with('success', 'Story deleted successfully.');
    }
}