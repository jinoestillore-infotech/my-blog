<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('index');
});

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
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.store');

    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1')->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/tots', function () {
        return view('pages.index');
    })->name('tots');

    // Secure Post writing operations
    Route::get('/my-library', [PostController::class, 'index'])->name('posts.index');
    Route::get('/write-story', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Public route to read individual posts (kept safe for later!)
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');