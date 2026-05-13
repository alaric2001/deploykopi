<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RawJenisKopi;
use App\Models\Kopi;
use Illuminate\Support\Facades\Auth;

class RawJenisKopiController extends Controller
{
    public function index()
    {
        $raw_jenis_kopi = RawJenisKopi::all();
        return view('admin.jenis_kopi.raw_jeniskopi', compact('raw_jenis_kopi'));
    }

    public function add(Request $request)
    {
        RawJenisKopi::create([
            'nama' => $request->nama,
            'stok' => $request->stok,
        ]);
        return redirect()->back()->with('success', 'Berhasil tambah data');
    }

    // Method untuk mengupdate data rasa kopi
    public function update(Request $request, $id)
    {
        $raw_jenis_kopi = RawJenisKopi::findOrFail($id);
        $raw_jenis_kopi->nama = $request->nama;
        $raw_jenis_kopi->stok = $request->stok;
        $raw_jenis_kopi->save();

        return redirect()->back()->with('success', 'Data Jenis kopi berhasil diupdate.');
    }

    public function destroy($id)
    {
        $raw_jenis_kopi = RawJenisKopi::find($id);
        $raw_jenis_kopi->delete();
        return redirect()->back();
    }
}
