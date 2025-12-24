<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKesehatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_hewan',
        'spesies',          
        'jenis_hewan',
        'jenis_kelamin',
        'umur',             
        'umur_bulan',      
        'tanggal_pemeriksaan',
        'diagnosis',
        'tindakan',
        'dokter',
        'catatan',
        'jadwal_berikutnya',
    ];

    protected $casts = [
        'tanggal_pemeriksaan' => 'date',
        'jadwal_berikutnya' => 'date',
        'umur' => 'integer',        
        'umur_bulan' => 'integer',  
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUmurLengkapAttribute()
    {
        $tahun = $this->umur > 0 ? $this->umur . ' tahun' : '';
        $bulan = $this->umur_bulan > 0 ? $this->umur_bulan . ' bulan' : '';
        
        return trim($tahun . ' ' . $bulan) ?: '0 tahun';
    }
}