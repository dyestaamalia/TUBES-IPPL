<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class ForumController extends Controller
{
    // SHOW THREAD: 1 comment + semua balasan
    public function show(Comment $comment)
    {
        $comment->load([
            'user',
            'likes',
            'replies.user',
            'replies.likes'
        ]);

        return view('forum.show', compact('comment'));
    }
}