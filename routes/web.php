<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Login');
});

// ->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin', function () {
    return Inertia::render('AdminDashboard');
});

Route::get('/user', function () {
    return Inertia::render('UserDashboard');
});

require __DIR__.'/auth.php';
