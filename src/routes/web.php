<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/welcome', [AuthController::class, 'index'])->name('welcome');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'submitLogin']);
    Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
    Route::post('/signup', [AuthController::class, 'submitSignup']);
    Route::get('/auth/google', [AuthController::class, 'redirect']);
    Route::get('/auth/google/callback', [AuthController::class, 'callback']);
});

Route::middleware(['auth.custom', 'profile'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

Route::middleware(['auth.custom'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/complete-profile', [ProfileController::class, 'showForm'])->name('complete-profile');
    Route::post('/complete-profile', [ProfileController::class, 'updateProfile']);
});
