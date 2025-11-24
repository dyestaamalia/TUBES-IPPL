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

    // Relasi ke komentar
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relasi ke hewan peliharaan
    public function pets()
    {
        return $this->hasMany(\App\Models\Pet::class);
    }
}