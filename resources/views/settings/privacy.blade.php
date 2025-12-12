@extends('layouts.app')

@section('title', 'Privasi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('settings.index') }}" 
               class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 transition flex items-center justify-center">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Privasi</h1>
                <p class="text-sm text-gray-500">Kelola privasi dan data pribadi anda</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-pink-50">
            <h3 class="font-bold text-lg flex items-center gap-2">
                <span class="text-2xl">🔒</span>
                Pengaturan Privasi
            </h3>
        </div>

        <div class="p-6 space-y-4">
            <div class="flex items-center justify-between p-4 hover:bg-gray-50 rounded-xl transition">
                <div>
                    <h4 class="font-semibold text-gray-900">Profil Publik</h4>
                    <p class="text-sm text-gray-500">Izinkan orang lain melihat profil anda</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-cyan-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-cyan-600"></div>
                </label>
            </div>

            <div class="flex items-center justify-between p-4 hover:bg-gray-50 rounded-xl transition">
                <div>
                    <h4 class="font-semibold text-gray-900">Tampilkan Email</h4>
                    <p class="text-sm text-gray-500">Perlihatkan email di profil publik</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-cyan-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-cyan-600"></div>
                </label>
            </div>

            <div class="flex items-center justify-between p-4 hover:bg-gray-50 rounded-xl transition">
                <div>
                    <h4 class="font-semibold text-gray-900">Aktivitas Online</h4>
                    <p class="text-sm text-gray-500">Tampilkan status online anda</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-cyan-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-cyan-600"></div>
                </label>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-red-50 to-orange-50">
            <h3 class="font-bold text-lg flex items-center gap-2">
                <span class="text-2xl">🗑️</span>
                Data & Akun
            </h3>
        </div>

        <div class="p-6 space-y-3">
            <button class="w-full p-4 text-left hover:bg-gray-50 rounded-xl transition border border-gray-200">
                <h4 class="font-semibold text-gray-900">Download Data Saya</h4>
                <p class="text-sm text-gray-500">Unduh semua data yang anda miliki</p>
            </button>

            <button class="w-full p-4 text-left hover:bg-red-50 rounded-xl transition border border-red-200">
                <h4 class="font-semibold text-red-600">Hapus Akun</h4>
                <p class="text-sm text-gray-500">Hapus akun dan semua data secara permanen</p>
            </button>
        </div>
    </div>
</div>
@endsection