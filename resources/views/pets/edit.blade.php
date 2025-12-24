@extends('layouts.app')

@section('title', 'Edit Riwayat Kesehatan')

@section('content')
<form action="{{ route('riwayat.update', $riwayat->id) }}" method="POST">
    @csrf
    @method('PUT')
<div class="">

    <!-- Banner -->
    <div class="bg-[#13CAD6] text-white px-6 py-4 rounded-xl flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="bg-white/30 p-3 rounded-full text-2xl">🩺</div>
            <div>
                <h2 class="text-xl font-semibold">Edit Riwayat Kesehatan</h2>
                <p class="text-sm text-white/80">Perbarui data pemeriksaan hewan</p>
            </div>
        </div>
        <a href="{{ route('riwayat') }}" class="text-white text-xl">✖</a>
    </div>

    <!-- FORM -->
    <form action="{{ route('riwayat.update', $riwayat->id) }}" 
          method="POST" 
          class="mt-6 space-y-8">

        @csrf
        @method('PUT')

        <!-- Informasi Hewan -->
        <div class="bg-white border rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold mb-4">1. Informasi Hewan</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="font-medium">Nama Hewan *</label>
                    <input type="text" name="nama_hewan"
                        value="{{ old('nama_hewan', $riwayat->nama_hewan) }}"
                        class="w-full p-3 border rounded-xl mt-1" required>
                </div>

                <div>
                    <label class="font-medium">Jenis Hewan *</label>
                    <input type="text" name="jenis_hewan"
                        value="{{ old('jenis_hewan', $riwayat->jenis_hewan) }}"
                        class="w-full p-3 border rounded-xl mt-1" required>
                </div>

                <div>
                    <label class="font-medium">Jenis Kelamin *</label>
                    <select name="jenis_kelamin"
                        class="w-full p-3 border rounded-xl mt-1" required>
                        <option value="Jantan"
                            {{ old('jenis_kelamin', $riwayat->jenis_kelamin) == 'Jantan' ? 'selected' : '' }}>
                            Jantan
                        </option>
                        <option value="Betina"
                            {{ old('jenis_kelamin', $riwayat->jenis_kelamin) == 'Betina' ? 'selected' : '' }}>
                            Betina
                        </option>
                    </select>
                </div>

            </div>
        </div>

        <!-- Informasi Pemeriksaan -->
        <div class="bg-white border rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold mb-4">2. Informasi Pemeriksaan</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="font-medium">Tanggal Pemeriksaan *</label>
                    <input type="date" name="tanggal_pemeriksaan"
                        value="{{ old('tanggal_pemeriksaan', $riwayat->tanggal_pemeriksaan) }}"
                        class="w-full p-3 border rounded-xl mt-1" required>
                </div>

                <div>
                    <label class="font-medium">Dokter *</label>
                    <input type="text" name="dokter"
                        value="{{ old('dokter', $riwayat->dokter) }}"
                        class="w-full p-3 border rounded-xl mt-1" required>
                </div>

                <div>
                    <label class="font-medium">Diagnosis *</label>
                    <input type="text" name="diagnosis"
                        value="{{ old('diagnosis', $riwayat->diagnosis) }}"
                        class="w-full p-3 border rounded-xl mt-1" required>
                </div>

                <div>
                    <label class="font-medium">Tindakan *</label>
                    <input type="text" name="tindakan"
                        value="{{ old('tindakan', $riwayat->tindakan) }}"
                        class="w-full p-3 border rounded-xl mt-1" required>
                </div>

            </div>
        </div>

        <!-- Catatan -->
        <div class="bg-white border rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold mb-4">3. Catatan Tambahan</h3>

            <textarea name="catatan" rows="3"
                class="w-full p-3 border rounded-xl mt-1">{{ old('catatan', $riwayat->catatan) }}</textarea>

            <div class="mt-4">
                <label class="font-medium">Jadwal Pemeriksaan Berikutnya</label>
                <input type="date" name="jadwal_berikutnya"
                    value="{{ old('jadwal_berikutnya', $riwayat->jadwal_berikutnya) }}"
                    class="w-full p-3 border rounded-xl mt-1">
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('riwayat') }}"
                class="px-6 py-2 border rounded-xl text-gray-600 hover:bg-gray-100">
                Batal
            </a>

            <button type="submit"
                class="px-6 py-2 bg-[#13CAD6] text-white rounded-xl hover:bg-[#0fb3c2] shadow">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
