<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExploreFeedController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\WriterReportController;

// Route::get('/', function () {
//     return view('index');
// });
// Clean Landing Page Route fetching real published posts
Route::get('/', function () {
    $recentPosts = \App\Models\Post::where('status', 'published')
        ->with(['user', 'likes'])
        ->latest()
        ->take(2)
        ->get();

    return view('index', compact('recentPosts'));
})->name('home');

Route::get('/privacy-policy', function () {
    return view('privacy');
    })->name('privacy');

Route::get('/terms-of-service', function () {
    return view('terms-of-service');
    })->name('terms');

Route::get('/community-standards', function () {
    return view('community-standards');
    })->name('community-standards');
// Route::get('/community', function () {
//         return view('community');
//     })->name('community');

// Community & Popularity Directories
Route::get('/community', [CommunityController::class, 'index'])->name('community');
// Publicly viewable Author Profiles
Route::get('/writers/{username}', [ProfileController::class, 'show'])->name('profile.show');

Route::middleware('guest')->group(function () {
    Route::get('/register-tots-account', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.store');

    Route::get('/login-to-tots', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1')->name('login.store');

    // Forgot Password Security recovery pipeline routes
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showRequestForm'])->name('password.request');
    Route::post('/forgot-password/email', [ForgotPasswordController::class, 'verifyEmail'])->name('password.email');
    Route::get('/forgot-password/reset', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Dedicated Administration Interface Portal (Separated Authentication)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    // Guest Admin Auth
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Authenticated Admin Dashboard Control Panel
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // User Management
        Route::get('/users', [AdminReportController::class, 'users'])->name('admin.users.index');
        Route::patch('/users/{id}/role', [AdminReportController::class, 'updateUserRole'])->name('admin.users.role');
        Route::delete('/users/{id}', [AdminReportController::class, 'destroyUser'])->name('admin.users.destroy');

        // Flagged Story Reports Moderation
        Route::get('/reports/stories', [AdminReportController::class, 'storyReports'])->name('admin.reports.stories');
        Route::patch('/reports/stories/{id}', [AdminReportController::class, 'updateStoryReport'])->name('admin.reports.stories.update');
        Route::delete('/reports/stories/violating/{id}', [AdminReportController::class, 'destroyViolatingStory'])->name('admin.reports.stories.destroy_story');

        // Flagged Writer Profile Reports Moderation
        Route::get('/reports/writers', [AdminReportController::class, 'writerReports'])->name('admin.reports.writers');
        Route::patch('/reports/writers/{id}', [AdminReportController::class, 'updateWriterReport'])->name('admin.reports.writers.update');
    });
});

Route::middleware('auth', 'activity')->group(function () {
    // Facebook-style Social Explore Feed (Strictly Authenticated)
    Route::get('/tots-feed', [ExploreFeedController::class, 'index'])->name('tots-feed');

    Route::get('/popular', [CommunityController::class, 'popular'])->name('popular');
    Route::get('/tots', [DashboardController::class, 'index'])->name('pages.index');

    Route::get('/tots-writers/search', [CommunityController::class, 'findWriters'])->name('writers.search');
    // Secure Post writing operations
    Route::get('/my-tots', [PostController::class, 'index'])->name('posts.index');
    Route::get('/write-a-tots', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    // Core Like interaction endpoint
    Route::post('/posts/{id}/like', [PostController::class, 'toggleLike'])->name('posts.like');

    // Secure Follow API Toggle Route
    Route::post('/users/{id}/follow', [FollowController::class, 'toggleFollow'])->name('users.follow');
    // Bookmark save to read later interaction endpoint
    Route::post('/posts/{id}/bookmark', [PostController::class, 'toggleBookmark'])->name('posts.bookmark');
    // Secure Community Reporting endpoints
    Route::post('/posts/{id}/report', [ReportController::class, 'store'])->name('posts.report');
    Route::post('/users/{id}/report', [WriterReportController::class, 'store'])
        ->name('users.report');
    // Dedicated Saved Queue / Reading List route
    Route::get('/my-saved-tots', [PostController::class, 'saved'])->name('posts.saved');

    // Dynamic User Profile Settings Workspace
    Route::get('/profile/edit-profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/settings/security', [SecurityController::class, 'index'])->name('settings');
    Route::get('/settings/security/password', [SecurityController::class, 'showPasswordForm'])->name('settings.password');
    Route::get('/settings/security/question', [SecurityController::class, 'showQuestionForm'])->name('settings.question');
    Route::put('/settings/security/password', [SecurityController::class, 'updatePassword'])->middleware('throttle:5,1')->name('settings.security.password');
    Route::put('/settings/security/question',[SecurityController::class, 'updateQuestion'])->middleware('throttle:5,1')->name('settings.security.question');


    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::post('/ai/improve', [AIController::class, 'improve'])->name('ai.improve');
});

// Public route to read individual posts (kept safe for later!)
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');