<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Report;
use App\Models\WriterReport;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the Admin Statistics and Control Center.
     */
    public function index()
    {
        $totalUsers = User::count();
        
        // Active users are classified as those communicating with the platform in the last 5 minutes
        $activeUsers = User::where('last_activity_at', '>=', now()->subMinutes(5))->count();

        // Count pending reports awaiting verification
        $pendingStoryReports = Report::where('status', 'pending')->count();
        $pendingWriterReports = WriterReport::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'pendingStoryReports',
            'pendingWriterReports'
        ));
    }
}