<?php

use Illuminate\Support\Facades\Route;

// Serve Vue app for all routes except API routes
Route::get('/', function () {
    return view('welcome');
});

// Serve Vue app for all other routes except API routes
Route::fallback(function () {
    // Check if this is an API route
    if (str_starts_with(request()->path(), 'api/')) {
        abort(404);
    }
    return view('welcome');
});
