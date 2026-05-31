<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExploreFeedController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;

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

Route::get('/community', function () {
        return view('community');
    })->name('community');

Route::middleware('guest')->group(function () {
    Route::get('/register-tots-account', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.store');

    Route::get('/login-to-tots', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1')->name('login.store');
});

Route::middleware('auth')->group(function () {
    // Facebook-style Social Explore Feed (Strictly Authenticated)
    Route::get('/tots-feed', [ExploreFeedController::class, 'index'])->name('tots-feed');
    // Community & Popularity Directories
    // Route::get('/community', [CommunityController::class, 'index'])->name('community');
    Route::get('/popular', [CommunityController::class, 'popular'])->name('popular');
    Route::get('/tots', [DashboardController::class, 'index'])->name('pages.index');
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
    
    // Dynamic User Profile Settings Workspace
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Public route to read individual posts (kept safe for later!)
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');