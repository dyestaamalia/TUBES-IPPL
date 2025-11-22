<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $comments = Comment::whereNull('parent_id')
                        ->with('user', 'likes', 'replies') // Load relasi
                        ->latest()
                        ->get();

        // Jika user login, ambil hewan peliharaan
        $pets = $user ? $user->pets()->get() : collect();

        // Tren diskusi REAL: Ambil 3 diskusi dengan interaksi terbanyak dalam 7 hari terakhir
        $trending = Comment::whereNull('parent_id')
                    ->where('created_at', '>=', Carbon::now()->subDays(7))
                    ->withCount([
                        'likes as likes_count',
                        'replies as replies_count'
                    ])
                    ->orderByRaw('(likes_count + replies_count) DESC')
                    ->limit(3)
                    ->get();

        return view('home', compact('comments', 'pets', 'trending'));
    }
}