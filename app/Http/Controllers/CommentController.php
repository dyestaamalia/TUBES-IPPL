<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Simpan komentar / balasan
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'parent_id' => $request->parent_id ?? null,
        ]);

        return back();
    }

    // **LIKE / UNLIKE**
   public function like($id)
{
    $comment = Comment::findOrFail($id);
    $user = auth()->user();

    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $comment->likes()->toggle($user->id);

    return response()->json([
        'likes_count' => $comment->likes()->count()
    ]);
}
}

