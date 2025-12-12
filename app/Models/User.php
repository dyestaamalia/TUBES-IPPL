<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 
        'email', 
        'phone', 
        'dob', 
        'password',
        'profile_photo',
        'address',
    ];

    protected $hidden = [
        'password', 
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi ke komentar yang dibuat user
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relasi ke hewan peliharaan
    public function pets()
    {
        return $this->hasMany(\App\Models\Pet::class);
    }

    // Relasi ke postingan yang di-like user
    public function likes()
    {
        return $this->belongsToMany(Comment::class, 'comment_user_likes', 'user_id', 'comment_id')
                    ->withTimestamps();
    }
}