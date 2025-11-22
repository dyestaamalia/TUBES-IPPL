@extends('layouts.app')

@section('content')
<div class="">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Hewan Peliharaan Saya</h1>
            <p class="text-gray-600 text-sm">Kelola informasi dan kesehatan hewan peliharaan Anda</p>
        </div>

        <a href="{{ route('pets.create') }}">
            <button class="bg-[#4EC4CE] text-white px-6 py-2 rounded-lg shadow-md hover:bg-[#3bb3bd] transition">
                + Tambah Hewan
            </button>
        </a>
    </div>

    <!-- Card Total Hewan -->
    <div class="mt-6">
        <div class="bg-white border p-5 rounded-2xl w-52 shadow-sm">
            <p class="text-gray-600 text-sm">Total Hewan</p>

            <div class="flex items-center justify-between mt-2">
                <h2 class="text-xl font-bold">{{ $totalHewan }}</h2>

                <div class="bg-[#DDF7FB] w-10 h-10 rounded-xl flex items-center justify-center">
                    🐾
                </div>
            </div>
        </div>
    </div>

    <!-- List Hewan -->
    <div class="mt-8">
        <h2 class="text-lg font-semibold mb-3">Daftar Hewan</h2>

        @if ($pets->count() == 0)
            <p class="text-gray-500 text-sm">Belum ada hewan yang ditambahkan.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                @foreach ($pets as $pet)
                <div class="bg-white border rounded-xl p-4 shadow-sm hover:shadow-md transition">

                    <!-- Bagian Foto + Nama -->
                    <div class="flex items-center">

                        <!-- FOTO HEWAN -->
                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 flex items-center justify-center">
                            @if ($pet->image)
                                <img src="{{ asset('storage/' . $pet->image) }}"
                                     class="w-full h-full object-cover">
                            @else
                                <span class="text-2xl">🐾</span>
                            @endif
                        </div>

                        <!-- INFO -->
                        <div class="ml-4">
                            <h3 class="text-lg font-bold">{{ $pet->name }}</h3>
                            <p class="text-gray-600 text-sm">{{ $pet->species }}</p>

                            @if ($pet->breed)
                                <p class="text-gray-500 text-xs">{{ $pet->breed }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-between mt-4">

                        <!-- Detail -->
                        <a href="{{ route('pets.show', $pet->id) }}"
                            class="text-blue-600 hover:underline text-sm">
                            Detail
                        </a>

                        <!-- Edit -->
                        <a href="{{ route('pets.edit', $pet->id) }}"
                            class="text-yellow-600 hover:underline text-sm">
                            Edit
                        </a>

                        <!-- Hapus -->
                        <form action="{{ route('pets.destroy', $pet->id) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus hewan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline text-sm">
                                Hapus
                            </button>
                        </form>

                    </div>

                </div>
                @endforeach

            </div>
        @endif
    </div>

</div>
@endsection
