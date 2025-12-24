<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatKesehatan;
use Carbon\Carbon;

class RiwayatKesehatanController extends Controller
{
    public function index()
    {
        $riwayats = RiwayatKesehatan::where('user_id', auth()->id())
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->get();

        return view('riwayat.kesehatan', [
            'riwayats' => $riwayats,
            'totalPemeriksaan' => $riwayats->count(),
            'hewanDiperiksa' => $riwayats->pluck('nama_hewan')->unique()->count(),
            'bulanIni' => $riwayats->filter(function ($item) {
                return Carbon::parse($item->tanggal_pemeriksaan)->isCurrentMonth();
            })->count(),
        ]);
    }

    public function create()
    {
        return view('riwayat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_hewan' => 'required|string|max:255',
            'spesies' => 'required|string|max:255', 
            'jenis_hewan' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Jantan,Betina',
            'umur' => 'nullable|integer|min:0', 
            'umur_bulan' => 'nullable|integer|min:0|max:11', 
            'tanggal_pemeriksaan' => 'required|date',
            'diagnosis' => 'required|string|max:255',
            'tindakan' => 'required|string',
            'dokter' => 'required|string|max:255',
            'catatan' => 'nullable|string',
            'jadwal_berikutnya' => 'nullable|date|after:tanggal_pemeriksaan',
        ]);

        RiwayatKesehatan::create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('riwayat')
            ->with('success', 'Riwayat kesehatan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $riwayat = RiwayatKesehatan::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('riwayat.edit', compact('riwayat'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_hewan' => 'required|string|max:255',
            'spesies' => 'required|string|max:255', 
            'jenis_hewan' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Jantan,Betina',
            'umur' => 'nullable|integer|min:0', 
            'umur_bulan' => 'nullable|integer|min:0|max:11', 
            'tanggal_pemeriksaan' => 'required|date',
            'diagnosis' => 'required|string|max:255',
            'tindakan' => 'required|string',
            'dokter' => 'required|string|max:255',
            'catatan' => 'nullable|string',
            'jadwal_berikutnya' => 'nullable|date|after_or_equal:tanggal_pemeriksaan',
        ]);

        RiwayatKesehatan::where('id', $id)
            ->where('user_id', auth()->id())
            ->update($validated);

        return redirect()
            ->route('riwayat')
            ->with('success', 'Riwayat kesehatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        RiwayatKesehatan::where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        return redirect()
            ->route('riwayat')
            ->with('success', 'Riwayat kesehatan berhasil dihapus!');
    }
}