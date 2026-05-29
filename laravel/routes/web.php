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