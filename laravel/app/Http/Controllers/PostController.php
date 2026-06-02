<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        // Require login for writing, saving, editing, and deleting posts
        $this->middleware('auth')->except(['show']);
    }

    /**
     * Display the authenticated user's library of posts.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $filter = $request->query('status'); // all | published | draft

        $baseQuery = $user->posts()->latest();

        if ($filter === 'published') {
            $baseQuery->published();
        } elseif ($filter === 'draft') {
            $baseQuery->where('status', 'draft');
        }

        $posts = $baseQuery->simplePaginate(9)->withQueryString();

        $allCount = $user->posts()->count();
        $publishedCount = $user->posts()->published()->count();
        $draftCount = $user->posts()->where('status', 'draft')->count();

        return view('posts.index', compact(
            'posts',
            'allCount',
            'publishedCount',
            'draftCount',
            'filter'
        ));
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
            'tags' => 'nullable|string|max:255',
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

        // Handle image upload directly into public/images/featured_images
        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Move file straight to public/images/featured_images/
            $image->move(public_path('images/featured_images'), $imageName);
            $imagePath = 'images/featured_images/' . $imageName;
        }

        // Create the post in the database attached to the logged-in user
        Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'excerpt' => $request->excerpt ?? Str::limit(strip_tags($request->content), 150),
            'tags' => $request->tags,
            'featured_image' => $imagePath,
            'status' => $request->status,
        ]);

        return redirect()->route('posts.index')->with('success', 'Your story was saved successfully!');
    }
    /**
     * Display the specified blog post to readers.
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->published()->firstOrFail();

        // Increment reads uniquely only if the user has not viewed this post yet
        if (Auth::check()) {
            $user = Auth::user();

            // Standard Eloquent relationship existence check
            if (!$post->viewsRelation()->where('user_id', $user->id)->exists()) {
                // Register unique view record using attach()
                $post->viewsRelation()->attach($user->id);

                // Increment total view count on posts table safely
                $post->increment('views');
            }
        }

        return view('posts.show', compact('post'));
    }

    /**
     * Toggle the authenticated user's like status on a post.
     */
    public function toggleLike($id)
    {
        $post = Post::findOrFail($id);
        $user = Auth::user();

        // Toggle connection in post_likes pivot table
        $liked = $post->likes()->toggle($user->id);

        return response()->json([
            'liked' => count($liked['attached']) > 0,
            'likes_count' => $post->likes()->count()
        ]);
    }

    /**
     * Toggle the authenticated user's bookmark/save state on a post.
     */
    public function toggleBookmark($id)
    {
        $post = Post::findOrFail($id);
        $user = Auth::user();

        // Toggle bookmark save state
        $saved = $post->bookmarkedBy()->toggle($user->id);

        return response()->json([
            'success' => true,
            'bookmarked' => count($saved['attached']) > 0
        ]);
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
            'tags' => 'nullable|string|max:255',
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

        // Update image directly inside public folder if a new one is uploaded
        if ($request->hasFile('featured_image')) {
            // Delete old file from public path if it exists to avoid server clutter
            if ($post->featured_image && file_exists(public_path($post->featured_image))) {
                @unlink(public_path($post->featured_image));
            }

            $image = $request->file('featured_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/featured_images'), $imageName);
            $post->featured_image = 'images/featured_images/' . $imageName;
        }

        $post->title = $request->title;
        $post->content = $request->content;
        $post->excerpt = $request->excerpt ?? Str::limit(strip_tags($request->content), 150);
        $post->status = $request->status;
        $post->tags = $request->tags;
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Your story has been updated!');
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

        // Delete post cover image file if it exists in public folder
        if ($post->featured_image && file_exists(public_path($post->featured_image))) {
            @unlink(public_path($post->featured_image));
        }

        $status = $post->status;

        $post->delete();

        $message = $status === 'draft'
            ? 'Draft deleted successfully.'
            : 'Published story deleted successfully.';

        return redirect()->route('posts.index')->with('success', $message);
    }
}