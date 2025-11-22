<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengingat;

class PengingatController extends Controller
{
    public function index()
    {
        return view('pengingat.pengingat_list', [
            'aktif' => Pengingat::where('status', 'aktif')->get(),
            'selesai' => Pengingat::where('status', 'selesai')->get(),
        ]);
    }

    public function create()
    {
        return view('pengingat.pengingat_create');
    }

    public function store(Request $req)
    {
        Pengingat::create([
            'nama_hewan' => $req->nama_hewan,
            'kategori' => $req->kategori,
            'tanggal' => $req->tanggal,
            'waktu' => $req->waktu,
            'deskripsi' => $req->deskripsi,
            'status' => 'aktif'
        ]);

        return redirect()->route('pengingat.list');
    }

    public function selesai($id)
    {
        Pengingat::find($id)->update([
            'status' => 'selesai'
        ]);

        return back();
    }

    public function delete($id)
    {
        Pengingat::find($id)->delete();

        return back();
    }
}
