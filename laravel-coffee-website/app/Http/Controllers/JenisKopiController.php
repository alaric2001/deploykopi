<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisKopi;
use App\Models\Kopi;
use App\Models\Cart;
use App\Models\Transaksi;
use App\Models\RawJenisKopi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class JenisKopiController extends Controller
{
    public function index()
    {
        // $jeniskopi = JenisKopi::all();
        $jeniskopi = JenisKopi::with(['raw_jeniskopi', 'kopi'])->get();
        $rawjeniskopi = RawJenisKopi::all();
        $kopi = Kopi::all();
        return view('admin.jenis_kopi.jenis_kopi', compact('jeniskopi', 'kopi', 'rawjeniskopi'));
    }

    public function add(Request $request)
    {
        JenisKopi::create([
            'kopi_id' => $request->nama_kopi,
            'id_rawjeniskopi' => $request->jenis,
        ]);
        return redirect()->back()->with('success', 'Berhasil tambah data');
    }

    // Method untuk mengupdate data rasa kopi
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'rasa' => 'required|string|max:255',
        //     'nama_kopi' => 'required|exists:kopi,id',
        // ]);

        $jeniskopi = JenisKopi::findOrFail($id);
        // $jeniskopi->nama_jenis = $request->jenis;
        $jeniskopi->id_rawjeniskopi = $request->jenis;
        $jeniskopi->kopi_id = $request->nama_kopi;
        $jeniskopi->save();

        return redirect()->back()->with('success', 'Data Jenis kopi berhasil diupdate.');
    }

    public function destroy($id)
    {
        $jenis_kopi = JenisKopi::find($id);
        $jenis_kopi->delete();
        return redirect()->back();
    }

    public function updateStatus(Request $request)
    {
        $status = $request->input('status');
        // JenisKopi::query()->update(['ready' => $status]);

        // $namaJenis = $request->input('nama_jenis');
        $namaJenis = $request->input('id_rawjeniskopi');

        JenisKopi::where('id_rawjeniskopi', $namaJenis)->update(['ready' => $status]);
        
        return response()->json(['message' => 'Status updated successfully.']);
    }

}