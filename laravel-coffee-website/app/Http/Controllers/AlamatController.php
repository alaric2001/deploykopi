<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Alamat;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AlamatController extends Controller
{
    public function index()
    {
        $data_alamat = Alamat::where('id_user', Auth::id())->get();
        return view('user.alamat.main', compact('data_alamat'));
    }

    public function inputalamatpage()
    {
        $data_kec= Kecamatan::all();
        $data_kel= Kelurahan::all();
        return view('user.alamat.add', compact('data_kec', 'data_kel'));
    }

    public function add(Request $request)
    {
        $data=[
            'id_user' => Auth::id(),
            'kab_kota' => 'Kota Bekasi',
            'kec' => $request->kecamatan,
            'kel' => $request->kelurahan,
            'kodepos' => $request->kode_pos,
            'detail'=> $request->detail_alamat
        ];

        if ($request->kecamatan == 'Bantar Gebang' || $request->kecamatan == 'Bekasi Barat' || 
            $request->kecamatan == 'Bekasi Timur' || $request->kecamatan == 'Bekasi Selatan' || 
            $request->kecamatan == 'Bekasi Utara') 
        {
            $data['harga_ongkir'] = 10000;
        } elseif($request->kecamatan == 'Rawalumbu'){
            $data['harga_ongkir'] = 0;
        } else {
            $data['harga_ongkir'] = 5000;
        }

        Alamat::create($data);
        
        return redirect('/alamat')->with('success', 'Berhasil Tambah Data');
    }

    public function detail($id)
    {
        $detail_alamat = Alamat::find($id);
        $data_kec= Kecamatan::all();
        $data_kel= Kelurahan::all();
        return view('user.alamat.detail', compact('detail_alamat', 'data_kec', 'data_kel'));
    }

    public function getKelurahan($kecamatan)
    {
        try {
            // Retrieve the kecamatan by its name
            $kecamatan = Kecamatan::where('nama_kec', $kecamatan)->first();
            
            if ($kecamatan) {
                // Retrieve all kelurahan associated with the kecamatan
                $kelurahan = Kelurahan::where('id_kec', $kecamatan->id)->get(['nama_kel']);
                return response()->json($kelurahan);
            } else {
                return response()->json(['error' => 'Kecamatan not found'], 404);
            }
        } catch (\Exception $e) {
            // Log the error for further investigation
            \Log::error('Error fetching kelurahan: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function update(Request $request, $id)
    {

        $alamat = Alamat::findOrFail($id);
        $alamat->kec = $request->kecamatan ?? $alamat->kec;
        $alamat->kel = $request->kelurahan ?? $alamat->ke;
        $alamat->kodepos = $request->kode_pos ?? $alamat->kodepos;
        $alamat->detail = $request->detail_alamat ?? $alamat->detail;

        if ($alamat->kec == 'Bantar Gebang' || $alamat->kec == 'Bekasi Barat' || 
            $alamat->kec == 'Bekasi Timur' || $alamat->kec == 'Bekasi Selatan' || 
            $alamat->kec == 'Bekasi Utara') 
        {
            $alamat->harga_ongkir = 10000;
        } elseif($alamat->kec == 'Rawalumbu'){
            $alamat->harga_ongkir = 0;
        } else {
            $alamat->harga_ongkir = 5000;
        }
        
        $alamat->save();

        return redirect()->back()->with('success', 'Data Jenis kopi berhasil diupdate.');
    }

    public function delete($id)
    {
        $alamat = Alamat::find($id);
        $alamat->delete();
        return redirect()->back();
    }
}
