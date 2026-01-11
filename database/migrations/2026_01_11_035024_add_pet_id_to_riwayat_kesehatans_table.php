<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('riwayat_kesehatans', function (Blueprint $table) {
            // ✅ Tambah kolom pet_id (foreign key ke pets table)
            $table->foreignId('pet_id')->after('user_id')->constrained('pets')->onDelete('cascade');
            
            // ✅ Hapus kolom-kolom yang sekarang ga perlu (karena udah ada di pets table)
            $table->dropColumn([
                'nama_hewan',
                'spesies',
                'jenis_hewan',
                'jenis_kelamin',
                'umur',
                'umur_bulan'
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('riwayat_kesehatans', function (Blueprint $table) {
            // Rollback: kembalikan kolom lama
            $table->string('nama_hewan');
            $table->string('spesies')->nullable();
            $table->string('jenis_hewan');
            $table->string('jenis_kelamin');
            $table->integer('umur')->nullable();
            $table->integer('umur_bulan')->nullable();
            
            // Hapus foreign key
            $table->dropForeign(['pet_id']);
            $table->dropColumn('pet_id');
        });
    }
};