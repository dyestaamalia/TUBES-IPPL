<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\PengingatController;

// HOME
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// AUTH
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('proseslogin');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'prosesRegister'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// COMMENT (Tambahkan middleware auth untuk yang perlu login)
Route::middleware(['auth'])->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/{id}/like', [CommentController::class, 'like'])->name('comments.like'); // ← UBAH JADI {id}
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// FORUM
Route::get('/forum/{comment}', [ForumController::class, 'show'])->name('forum.show');

// Hewan
Route::middleware(['auth'])->group(function () {

    // LIST
    Route::get('/hewan-saya', [PetController::class, 'index'])->name('hewan-saya');

    // CREATE
    Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
    Route::post('/pets', [PetController::class, 'store'])->name('pets.store');

    // DETAIL
    Route::get('/pets/{pet}', [PetController::class, 'show'])->name('pets.show');

    // EDIT
    Route::get('/pets/{pet}/edit', [PetController::class, 'edit'])->name('pets.edit');
    Route::put('/pets/{pet}', [PetController::class, 'update'])->name('pets.update');

    // DELETE
    Route::delete('/pets/{pet}', [PetController::class, 'destroy'])->name('pets.destroy');

});

// Pengingat List
Route::get('/pengingat', [PengingatController::class, 'index'])->name('pengingat.list');

// Tambah Pengingat (form)
Route::get('/pengingat/create', [PengingatController::class, 'create'])->name('pengingat.create');

// Simpan Pengingat
Route::post('/pengingat/store', [PengingatController::class, 'store'])->name('pengingat.store');

// Tandai selesai
Route::post('/pengingat/{id}/selesai', [PengingatController::class, 'selesai'])->name('pengingat.selesai');

// Delete
Route::delete('/pengingat/{id}', [PengingatController::class, 'delete'])->name('pengingat.delete');


