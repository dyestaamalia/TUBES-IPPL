<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Home
Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('proseslogin');

// Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'prosesRegister'])->name('register.post');

// Dashboard (contoh)
Route::get('/dashboard', function () {
    return "Welcome, you are logged in!";
})->name('dashboard');
