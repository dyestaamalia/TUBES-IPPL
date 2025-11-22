@extends('layouts.app')

@section('title', 'Edit Hewan')

@section('content')
<div class="">

    <!-- Banner Edit Hewan -->
    <div class="bg-[#13CAD6] text-white px-6 py-4 rounded-xl flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="bg-white/30 p-3 rounded-full text-2xl">✏️</div>
            <div>
                <h2 class="text-xl font-semibold">Edit Data Hewan</h2>
                <p class="text-sm text-white/80">Perbarui informasi hewan peliharaan</p>
            </div>
        </div>
        <a href="{{ route('hewan-saya') }}" class="text-white text-xl">✖</a>
    </div>

    <!-- FORM EDIT -->
    <form action="{{ route('pets.update', $pet->id) }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="mt-6 space-y-8">

        @csrf
        @method('PUT')

        <!-- Foto Hewan -->
        <div class="bg-white border rounded-xl p-6 shadow-sm">
            <label class="font-medium">Foto Saat Ini</label>
            <div class="mt-3">
                @if ($pet->photo)
                    <img src="{{ asset('storage/'.$pet->photo) }}" 
                         class="w-40 h-40 object-cover rounded-xl border">
                @else
                    <p class="text-gray-500 text-sm">Tidak ada foto.</p>
                @endif
            </div>

            <div class="mt-4">
                <label class="font-medium">Ganti Foto</label>
                <input type="file" name="photo" class="w-full mt-2">
            </div>
        </div>

        <!-- Informasi Dasar -->
        <div class="bg-white border rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold mb-4">1. Informasi Dasar</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="font-medium">Nama Hewan *</label>
                    <input type="text" name="name" class="w-full p-3 border rounded-xl mt-1"
                           value="{{ $pet->name }}" required>
                </div>

                <div>
                    <label class="font-medium">Jenis Hewan *</label>
                    <select name="species" class="w-full p-3 border rounded-xl mt-1" required>
                        <option {{ $pet->species == 'Kucing' ? 'selected' : '' }}>Kucing</option>
                        <option {{ $pet->species == 'Anjing' ? 'selected' : '' }}>Anjing</option>
                        <option {{ $pet->species == 'Burung' ? 'selected' : '' }}>Burung</option>
                        <option {{ $pet->species == 'Kelinci' ? 'selected' : '' }}>Kelinci</option>
                        <option {{ $pet->species == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="font-medium">Ras / Breed</label>
                    <input type="text" name="breed" class="w-full p-3 border rounded-xl mt-1"
                           value="{{ $pet->breed }}">
                </div>

                <div>
                    <label class="font-medium">Jenis Kelamin *</label>
                    <select name="gender" class="w-full p-3 border rounded-xl mt-1" required>
                        <option {{ $pet->gender == 'Jantan' ? 'selected' : '' }}>Jantan</option>
                        <option {{ $pet->gender == 'Betina' ? 'selected' : '' }}>Betina</option>
                    </select>
                </div>

                <div>
                    <label class="font-medium">Tanggal Lahir *</label>
                    <input type="date" name="birth_date" class="w-full p-3 border rounded-xl mt-1"
                           value="{{ $pet->birth_date }}" required>
                </div>

                <div>
                    <label class="font-medium">Berat Badan (Kg)</label>
                    <input type="number" step="0.1" name="weight" class="w-full p-3 border rounded-xl mt-1"
                           value="{{ $pet->weight }}">
                </div>

            </div>
        </div>

        <!-- Karakteristik Fisik -->
        <div class="bg-white border rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold mb-4">2. Karakteristik Fisik</h3>

            <label class="font-medium">Ciri Khusus</label>
            <textarea name="special_marks" rows="3"
                      class="w-full p-3 border rounded-xl mt-1">{{ $pet->special_marks }}</textarea>
        </div>

        <!-- Informasi Kesehatan -->
        <div class="bg-white border rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold mb-4">3. Informasi Kesehatan</h3>

            <label class="font-medium">Status Steril</label>
            <select name="is_steril" class="w-full p-3 border rounded-xl mt-1">
                <option value="1" {{ $pet->is_steril == 1 ? 'selected' : '' }}>Sudah</option>
                <option value="0" {{ $pet->is_steril == 0 ? 'selected' : '' }}>Belum</option>
            </select>

            <div class="mt-4">
                <label class="font-medium">Alergi</label>
                <input type="text" name="allergies" class="w-full p-3 border rounded-xl mt-1"
                       value="{{ $pet->allergies }}">
            </div>

            <div class="mt-4">
                <label class="font-medium">Kondisi Kesehatan Khusus</label>
                <textarea name="health_notes" rows="3"
                          class="w-full p-3 border rounded-xl mt-1">{{ $pet->health_notes }}</textarea>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('hewan-saya') }}" 
               class="px-6 py-2 border rounded-xl text-gray-600 hover:bg-gray-100">Batal</a>

            <button type="submit" 
                    class="px-6 py-2 bg-[#13CAD6] text-white rounded-xl hover:bg-[#0fb3c2] shadow">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
