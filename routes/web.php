<?php

use App\Http\Middleware\isAdminInertia;
use App\Http\Middleware\JwtInertiaMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Login');
})->name('home');

Route::middleware([JwtInertiaMiddleware::class, isAdminInertia::class])->get('/admin', function () {
    return Inertia::render('AdminDashboard');
})->name('admin');

Route::middleware(JwtInertiaMiddleware::class)->get('/user', function () {
    return Inertia::render('UserDashboard');
})->name('user');
