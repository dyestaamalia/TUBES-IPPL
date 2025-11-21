<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $comments = Comment::whereNull('parent_id')
                        ->with('user', 'likes') // Load relasi user & likes
                        ->latest()
                        ->get();

        // Jika user login, ambil hewan peliharaan, jika tidak, collection kosong
        $pets = $user ? $user->pets()->get() : collect();

        // Tren diskusi: komentar terbaru
        $trending = Comment::with('user')->latest()->take(3)->get();

        return view('home', compact('comments', 'pets', 'trending'));
    }
}
