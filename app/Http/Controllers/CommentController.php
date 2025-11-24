<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    /**
     * Simpan post/komentar baru dengan title, image (support nested replies)
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'title' => 'nullable|string|max:100',
            'parent_id' => 'nullable|exists:comments,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('comments', 'public');
        }

        Comment::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'title' => $request->title,
            'image' => $imagePath,
            'parent_id' => $request->parent_id ?? null,
        ]);

        // Redirect sesuai context
        if ($request->parent_id) {
            // Cari root parent untuk redirect
            $parent = Comment::find($request->parent_id);
            $rootId = $parent->parent_id ?? $parent->id;
            
            return redirect()->route('forum.show', $rootId)
                ->with('success', 'Balasan berhasil ditambahkan!');
        }

        return back()->with('success', 'Diskusi berhasil diposting!');
    }

    /**
     * Like / Unlike komentar
     */
    public function like($id)
    {
        try {
            \Log::info('Like request received for comment: ' . $id);
            
            $comment = Comment::findOrFail($id);
            $user = auth()->user();

            if (!$user) {
                \Log::error('User not authenticated');
                return response()->json([
                    'success' => false,
                    'error' => 'Unauthorized'
                ], 401);
            }

            // Toggle like
            if ($comment->likes()->where('user_id', $user->id)->exists()) {
                $comment->likes()->detach($user->id);
                $isLiked = false;
            } else {
                $comment->likes()->attach($user->id);
                $isLiked = true;
            }

            // Reload likes count
            $likesCount = $comment->likes()->count();
            
            \Log::info('Like toggled successfully', [
                'likes_count' => $likesCount,
                'is_liked' => $isLiked
            ]);

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

        // Delete image if exists
        if ($comment->image) {
            Storage::disk('public')->delete($comment->image);
        }

        // Delete all replies (cascade) - RECURSIVE
        $this->deleteCommentAndReplies($comment);

        return response()->json([
            'success' => true,
            'message' => 'Diskusi berhasil dihapus!'
        ]);
    }

    /**
     * Helper: Delete comment and all its nested replies recursively
     */
    private function deleteCommentAndReplies($comment)
    {
        // Get all direct replies
        $replies = Comment::where('parent_id', $comment->id)->get();
        
        // Recursively delete each reply
        foreach ($replies as $reply) {
            $this->deleteCommentAndReplies($reply);
        }
        
        // Delete image if exists
        if ($comment->image) {
            Storage::disk('public')->delete($comment->image);
        }
        
        // Delete the comment itself
        $comment->delete();
    }
}