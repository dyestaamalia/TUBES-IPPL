@extends('layouts.app')

@section('title', 'Tambah Riwayat Kesehatan')

@section('content')
<div class="">

    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('riwayat') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold">Tambah Riwayat Kesehatan</h1>
        </div>
        <p class="text-gray-600 text-sm ml-9">Catat hasil pemeriksaan kesehatan hewan peliharaan Anda</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-sm border p-6 md:p-8 max-w-3xl">
        
        <form action="{{ route('riwayat.store') }}" method="POST">
            @csrf

            <!-- Nama Hewan -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Hewan Peliharaan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_hewan" value="{{ old('nama_hewan') }}" required placeholder="Contoh: Meng, Selow, Kuki" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4EC4CE] focus:border-transparent @error('nama_hewan') border-red-500 @enderror">
                @error('nama_hewan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- ✅ SPESIES (BARU) -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Spesies <span class="text-red-500">*</span>
                </label>
                <input type="text" name="spesies" value="{{ old('spesies') }}" required placeholder="Contoh: Kucing Persia, Anjing Golden Retriever, Kura-kura Brazil" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4EC4CE] focus:border-transparent @error('spesies') border-red-500 @enderror">
                @error('spesies')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Hewan -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Jenis Hewan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="jenis_hewan" value="{{ old('jenis_hewan') }}" required placeholder="Contoh: Kucing, Anjing, Kura-kura" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4EC4CE] focus:border-transparent @error('jenis_hewan') border-red-500 @enderror">
                @error('jenis_hewan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Kelamin -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Jenis Kelamin <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="jenis_kelamin" value="Jantan" {{ old('jenis_kelamin') == 'Jantan' ? 'checked' : '' }} required class="w-4 h-4 text-[#4EC4CE] focus:ring-[#4EC4CE]">
                        <span class="text-gray-700">Jantan</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="jenis_kelamin" value="Betina" {{ old('jenis_kelamin') == 'Betina' ? 'checked' : '' }} required class="w-4 h-4 text-[#4EC4CE] focus:ring-[#4EC4CE]">
                        <span class="text-gray-700">Betina</span>
                    </label>
                </div>
                @error('jenis_kelamin')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- ✅ UMUR (BARU) -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Umur Hewan
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <input type="number" name="umur" value="{{ old('umur', 0) }}" min="0" placeholder="Tahun" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4EC4CE] focus:border-transparent @error('umur') border-red-500 @enderror">
                        <p class="text-gray-500 text-xs mt-1">Tahun</p>
                        @error('umur')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <input type="number" name="umur_bulan" value="{{ old('umur_bulan', 0) }}" min="0" max="11" placeholder="Bulan" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4EC4CE] focus:border-transparent @error('umur_bulan') border-red-500 @enderror">
                        <p class="text-gray-500 text-xs mt-1">Bulan (0-11)</p>
                        @error('umur_bulan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Tanggal Pemeriksaan -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Tanggal Pemeriksaan <span class="text-red-500">*</span>
                </label>
                <input type="date" name="tanggal_pemeriksaan" value="{{ old('tanggal_pemeriksaan', date('Y-m-d')) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4EC4CE] focus:border-transparent @error('tanggal_pemeriksaan') border-red-500 @enderror">
                @error('tanggal_pemeriksaan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Diagnosis -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Diagnosis <span class="text-red-500">*</span>
                </label>
                <input type="text" name="diagnosis" value="{{ old('diagnosis') }}" required placeholder="Contoh: Cacingan, Flu Kucing, dll" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4EC4CE] focus:border-transparent @error('diagnosis') border-red-500 @enderror">
                @error('diagnosis')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tindakan -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Tindakan yang Dilakukan <span class="text-red-500">*</span>
                </label>
                <textarea name="tindakan" rows="3" required placeholder="Contoh: Pemberian obat cacing, Vaksinasi, dll" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4EC4CE] focus:border-transparent @error('tindakan') border-red-500 @enderror">{{ old('tindakan') }}</textarea>
                @error('tindakan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Dokter -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Dokter <span class="text-red-500">*</span>
                </label>
                <input type="text" name="dokter" value="{{ old('dokter') }}" required placeholder="Contoh: Dr. Denis" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4EC4CE] focus:border-transparent @error('dokter') border-red-500 @enderror">
                @error('dokter')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catatan -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Catatan Tambahan
                </label>
                <textarea name="catatan" rows="3" placeholder="Catatan khusus atau instruksi dari dokter" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4EC4CE] focus:border-transparent @error('catatan') border-red-500 @enderror">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jadwal Pemeriksaan Berikutnya -->
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Jadwal Pemeriksaan Berikutnya
                </label>
                <input type="date" name="jadwal_berikutnya" value="{{ old('jadwal_berikutnya') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4EC4CE] focus:border-transparent @error('jadwal_berikutnya') border-red-500 @enderror">
                <p class="text-gray-500 text-xs mt-1">Opsional - Isi jika ada jadwal kontrol berikutnya</p>
                @error('jadwal_berikutnya')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-[#4EC4CE] text-white px-6 py-3 rounded-lg shadow-md hover:bg-[#3bb3bd] transition font-medium">
                    <i class="fas fa-save mr-2"></i> Simpan Riwayat
                </button>
                <a href="{{ route('riwayat') }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium text-gray-700">
                    Batal
                </a>
            </div>

        </form>

    </div>

</div>

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

@endsection