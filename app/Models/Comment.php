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
     * Like sistem pivot: comment_user_likes
     */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'comment_user_likes',
            'comment_id',
            'user_id'
        )->withTimestamps();
    }

    /**
     * Balasan/replies
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
}