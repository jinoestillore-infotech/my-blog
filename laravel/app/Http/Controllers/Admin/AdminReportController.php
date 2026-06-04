<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Report;
use App\Models\WriterReport;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    /**
     * 1. USER MANAGEMENT SECTION
     */
    public function users(Request $request)
    {
        $search = $request->query('search');
        $query = User::withCount('posts');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('username', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        return view('admin.users', compact('users', 'search'));
    }

    /**
     * Update user role or administrative classification.
     */
    public function updateUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'role' => 'required|in:admin,moderator,reader,writer'
        ]);

        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'You cannot modify your own administrative role.']);
        }

        $user->update(['role' => $request->role]);

        return back()->with('success', "User \"{$user->name}\" has been reclassified as: " . ucfirst($request->role));
    }

    /**
     * Delete or Ban a user profile.
     */
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'You cannot remove your own administrative profile.']);
        }

        $user->delete();

        return back()->with('success', "User \"{$user->name}\" was successfully purged from the system databases.");
    }


    /**
     * 2. STORY REPORTS MANAGEMENT
     */
    public function storyReports(Request $request)
    {
        $status = $request->query('status', 'pending');
        $query = Report::with(['user', 'post.user']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $reports = $query->latest()->paginate(15)->withQueryString();
        return view('admin.story_reports', compact('reports', 'status'));
    }

    /**
     * Update a story report status (Dismiss or Resolve).
     */
    public function updateStoryReport(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $request->validate([
            'status' => 'required|in:resolved,dismissed'
        ]);

        $report->update(['status' => $request->status]);

        return back()->with('success', "Story report status updated to: " . ucfirst($request->status));
    }

    /**
     * Delete the violating story directly from Admin Panel (Resolves the report).
     */
    public function destroyViolatingStory($id)
    {
        $post = Post::findOrFail($id);
        
        // Retrieve and delete any associated files to protect storage limits
        if ($post->featured_image && file_exists(public_path($post->featured_image))) {
            @unlink(public_path($post->featured_image));
        }

        // Auto-resolve any outstanding reports associated with this specific post
        Report::where('post_id', $post->id)->update(['status' => 'resolved']);

        $post->delete();

        return back()->with('success', 'The violating story was successfully deleted and related flags have been auto-resolved.');
    }


    /**
     * 3. WRITER REPORTS MANAGEMENT
     */
    public function writerReports(Request $request)
    {
        $status = $request->query('status', 'pending');
        $query = WriterReport::with(['reporter', 'reportedUser']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $reports = $query->latest()->paginate(15)->withQueryString();
        return view('admin.writer_reports', compact('reports', 'status'));
    }

    /**
     * Update a writer profile report status.
     */
    public function updateWriterReport(Request $request, $id)
    {
        $report = WriterReport::findOrFail($id);
        $request->validate([
            'status' => 'required|in:resolved,dismissed'
        ]);

        $report->update(['status' => $request->status]);

        return back()->with('success', "Writer report status updated to: " . ucfirst($request->status));
    }
}