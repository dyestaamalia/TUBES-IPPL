<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'title',        // Judul post
        'hashtags',     // Hashtags (comma separated)
        'image',        // Path gambar
        'parent_id'
    ];

    /**
     * User yang membuat komentar/post
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Alias author (optional)
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi likes untuk komentar atau post
     * Pivot table: comment_user_likes
     */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'comment_user_likes', 'comment_id', 'user_id')
                    ->withTimestamps();
    }

    /**
     * Balasan komentar
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')
                    ->with(['user', 'likes']);
    }

    /**
     * Parent comment
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Get hashtags as array
     */
    public function getHashtagsArrayAttribute()
    {
        return $this->hashtags ? explode(',', $this->hashtags) : [];
    }

    /**
     * Sistem Like/Unlike
     */
    public function like($id)
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
}
