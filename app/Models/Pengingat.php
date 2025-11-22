<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengingat extends Model
{
    use HasFactory;

    protected $table = 'pengingats';

    protected $fillable = [
        'nama_hewan',
        'kategori',
        'tanggal',
        'waktu',
        'deskripsi',
        'status'
    ];
}
