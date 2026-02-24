<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/welcome', [AuthController::class, 'index'])->name('welcome');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
});

Route::middleware(['auth.custom'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});
