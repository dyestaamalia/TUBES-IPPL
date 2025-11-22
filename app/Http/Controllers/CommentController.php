<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Simpan post/komentar baru dengan title & hashtags
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'title' => 'nullable|string|max:100',
            'hashtags' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        // Process hashtags - pastikan format #hashtag
        $hashtags = null;
        if ($request->hashtags) {
            $tags = array_map(function($tag) {
                $tag = trim($tag);
                return strpos($tag, '#') === 0 ? $tag : '#' . $tag;
            }, explode(',', $request->hashtags));
            $hashtags = implode(',', array_filter($tags));
        }

        Comment::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'title' => $request->title,
            'hashtags' => $hashtags,
            'parent_id' => $request->parent_id ?? null,
        ]);

        // Redirect sesuai context
        if ($request->parent_id) {
            return redirect()->route('forum.show', $request->parent_id)
                ->with('success', 'Balasan berhasil ditambahkan!');
        }

        return back()->with('success', 'Diskusi berhasil diposting!');
    }

    /**
     * Like / Unlike komentar
     */
    public function like($id)  // ← pastikan parameter $id
{
    try {
        $comment = Comment::findOrFail($id);
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized'
            ], 401);
        }

        // Toggle like
        $comment->likes()->toggle($user->id);

        // Reload likes
        $likesCount = $comment->likes()->count();
        $isLiked = $comment->likes()->where('user_id', $user->id)->exists();

        return response()->json([
            'success' => true,
            'likes_count' => $likesCount,
            'is_liked' => $isLiked
        ]);

    } catch (\Exception $e) {
        \Log::error('Like error: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
}

    /**
     * Hapus post/komentar
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        // Authorization check
        if ($comment->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Delete all replies (cascade)
        $comment->replies()->delete();
        
        // Delete comment
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Diskusi berhasil dihapus!'
        ]);
    }
}