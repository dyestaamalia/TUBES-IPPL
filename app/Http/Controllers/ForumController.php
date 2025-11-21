<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class ForumController extends Controller
{
    // Home page: hanya parent comments
    public function index() {
        $comments = Comment::whereNull('parent_id')->with('likes', 'user')->latest()->get();
        return view('home', compact('comments'));
    }

    // Show forum: parent comment + semua balasan
    public function show(Comment $comment) {
        $comment->load('user', 'likes', 'replies.user', 'replies.likes', 'replies.replies'); // load nested replies
        return view('forum.show', compact('comment'));
    }
}

