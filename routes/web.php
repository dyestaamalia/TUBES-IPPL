<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ForumController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini kita definisikan semua route untuk Home, Auth, Comment, dan Forum.
|
*/

// =======================
// Home / Dashboard
// =======================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// =======================
// Authentication (Login/Register/Logout)
// =======================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('proseslogin');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'prosesRegister'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =======================
// Comment
// =======================
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/comments/{comment}/like', [CommentController::class, 'like'])->name('comments.like');

// =======================
// Forum
// =======================
// Menampilkan parent comment + semua balasan
Route::get('/forum/{comment}', [ForumController::class, 'show'])->name('forum.show');
