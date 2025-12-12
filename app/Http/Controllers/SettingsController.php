<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    /**
     * Tampilkan halaman settings utama
     */
    public function index()
    {
        $user = Auth::user();
        return view('settings.index', compact('user'));
    }

    /**
     * Halaman Notifikasi Settings
     */
    public function notifications()
    {
        $user = Auth::user();
        // Nanti bisa ambil preference notifikasi dari database
        return view('settings.notifications', compact('user'));
    }

    /**
     * Update Notifikasi Preferences
     */
    public function updateNotifications(Request $request)
    {
        // Implementasi update notifikasi preferences
        // Bisa disimpan di tabel user_settings atau di user table
        
        return back()->with('success', 'Pengaturan notifikasi berhasil diperbarui!');
    }

    /**
     * Halaman Keamanan
     */
    public function security()
    {
        $user = Auth::user();
        return view('settings.security', compact('user'));
    }

    /**
     * Update Password dari Settings
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'password.required' => 'Password baru wajib diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah!');
    }

    /**
     * Halaman Privasi
     */
    public function privacy()
    {
        $user = Auth::user();
        return view('settings.privacy', compact('user'));
    }

    /**
     * Halaman Bahasa
     */
    public function language()
    {
        $user = Auth::user();
        return view('settings.language', compact('user'));
    }

    /**
     * Halaman Tampilan
     */
    public function appearance()
    {
        $user = Auth::user();
        return view('settings.appearance', compact('user'));
    }

    /**
     * Halaman Bantuan & Dukungan
     */
    public function help()
    {
        $user = Auth::user();
        return view('settings.help', compact('user'));
    }
}