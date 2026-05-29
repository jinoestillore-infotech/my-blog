<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/register', function () {
       return view('auth.register');
   })->name('register');

Route::get('/login', function () {
       return view('auth.login');
   })->name('login');

// // Post route will process user data and save it in your `users` table
// Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);