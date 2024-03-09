<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;

Auth::routes(['verify' => false]);

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('main');
    })->name('login');
    
    Route::get('/register', function () {
        return view('main');
    })->name('register');

    Route::get('/', [HomeController::class, 'index'])->name('home');
    
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/validatePhone', [DashboardController::class, 'validatePhone'])->name('validatePhone')->middleware('auth');