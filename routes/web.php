<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\PetController;

// ==========================================
// WELCOME PAGE (Landing Page)
// ==========================================
Route::get('/', function() {
    if (auth()->check()) {
        return redirect()->route('home');
    }
    return view('welcome');
})->name('welcome');

// ==========================================
// AUTHENTICATION ROUTES
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('proseslogin');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'prosesRegister'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ==========================================
// HOME/DASHBOARD (Require Authentication)
// ==========================================
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
});

// ==========================================
// FORUM ROUTES
// ==========================================
// Halaman Forum Utama (dengan filter: trending, terbaru, populer)
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');

// Detail Thread/Diskusi + Balasan
Route::get('/forum/{comment}', [ForumController::class, 'show'])->name('forum.show');

// ==========================================
// COMMENT ROUTES (Require Authentication)
// ==========================================
Route::middleware(['auth'])->group(function () {
    // Create Comment/Post
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    
    // Like/Unlike Comment
    Route::post('/comments/{id}/like', [CommentController::class, 'like'])->name('comments.like');
    
    // Delete Comment
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// ==========================================
// PET/HEWAN ROUTES (Require Authentication)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // List Hewan Milik User
    Route::get('/hewan-saya', [PetController::class, 'index'])->name('hewan-saya');
    
    // Create Hewan
    Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
    Route::post('/pets', [PetController::class, 'store'])->name('pets.store');
    
    // Detail Hewan
    Route::get('/pets/{pet}', [PetController::class, 'show'])->name('pets.show');
    
    // Edit Hewan
    Route::get('/pets/{pet}/edit', [PetController::class, 'edit'])->name('pets.edit');
    Route::put('/pets/{pet}', [PetController::class, 'update'])->name('pets.update');
    
    // Delete Hewan
    Route::delete('/pets/{pet}', [PetController::class, 'destroy'])->name('pets.destroy');
});

// ==========================================
// PLACEHOLDER ROUTES (Belum ada controller)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // Riwayat Kesehatan
    Route::get('/riwayat', function() {
        return view('placeholder', ['title' => 'Riwayat Kesehatan', 'message' => 'Fitur ini sedang dalam pengembangan']);
    })->name('riwayat');
    
    // Pengingat
    Route::get('/pengingat', function() {
        return view('placeholder', ['title' => 'Pengingat', 'message' => 'Fitur ini sedang dalam pengembangan']);
    })->name('pengingat');
    
    // Profil
    Route::get('/profil', function() {
        return view('placeholder', ['title' => 'Profil Saya', 'message' => 'Fitur ini sedang dalam pengembangan']);
    })->name('profil');
});