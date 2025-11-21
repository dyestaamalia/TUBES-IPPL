<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Comment extends Model
{
    protected $fillable = ['user_id', 'content', 'parent_id'];

    // Relasi ke user (pemilik komentar)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Alias author supaya Blade bisa pakai $comment->author
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi likes (user yang menyukai komentar)
    public function likes(): BelongsToMany
    {
        // Pivot table: comment_user_likes
        // comment_id -> foreign key ke Comment
        // user_id -> foreign key ke User
        return $this->belongsToMany(User::class, 'comment_user_likes', 'comment_id', 'user_id')->withTimestamps();
    }

    // Balasan komentar
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('user', 'likes', 'replies');
    }

    // Parent komentar
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}
