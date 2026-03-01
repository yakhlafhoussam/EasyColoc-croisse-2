<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DevController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\NewColocationController;
use App\Http\Controllers\PayController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RateController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/invitation/accept/{token}', [InvitationController::class, 'accept']);

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
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/newcolo', [NewColocationController::class, 'index'])->name('colocation');
    Route::post('/newcolo', [NewColocationController::class, 'store']);
    Route::post('/invitation', [InvitationController::class, 'sendInvitation']);
    Route::post('/categories', [CategoryController::class, 'addnew']);
    Route::post('/deletecat', [CategoryController::class, 'delete'])->name('delete');
    Route::post('/expense', [ExpenseController::class, 'addnew']);
    Route::post('/settle', [PayController::class, 'addnew']);
    Route::post('/rating', [RateController::class, 'addnew']);
    Route::post('/leave', [LeaveController::class, 'leave']);
    Route::post('/kick', [LeaveController::class, 'kick']);
});

Route::middleware(['auth.custom'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/complete-profile', [ProfileController::class, 'showForm'])->name('complete-profile');
    Route::get('/verifier-profile', [ProfileController::class, 'showVerifier'])->name('verifier-profile');
    Route::post('/complete-profile', [ProfileController::class, 'updateProfile']);
    Route::post('/verifier-profile', [ProfileController::class, 'submitVerifier']);
});

Route::middleware(['permission:1'])->group(function () {
    Route::get('/manage', [ManagementController::class, 'index'])->name('manage');
    Route::post('/ban', [ManagementController::class, 'ban']);
    Route::post('/unban', [ManagementController::class, 'unban']);
});

Route::get('/hyk', [DevController::class, 'index']);