<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RasaKopi;
use App\Models\Kopi;
use App\Models\Cart;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RasaKopiController extends Controller
{
    public function index()
    {
        $rasakopi = RasaKopi::all();
        $kopi = Kopi::all();
        return view('admin.rasakopi.list_rasa', compact('rasakopi', 'kopi'));
    }

    public function add(Request $request)
    {
        RasaKopi::create([
            'kopi_id' => $request->nama_kopi,
            'nama_rasa' => $request->rasa,
        ]);
        
        // Redirect ke rute /cart setelah item berhasil ditambahkan ke keranjang
        return redirect()->back()->with('success', 'Item added to cart');
    }

    // Method untuk mengupdate data rasa kopi
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'rasa' => 'required|string|max:255',
        //     'nama_kopi' => 'required|exists:kopi,id',
        // ]);

        $rasakopi = RasaKopi::findOrFail($id);
        $rasakopi->nama_rasa = $request->rasa;
        $rasakopi->kopi_id = $request->nama_kopi;
        $rasakopi->save();

        return redirect()->back()->with('success', 'Data rasa kopi berhasil diupdate.');
    }

    public function destroy($id)
    {
        $rasa_kopi = RasaKopi::find($id);
        $rasa_kopi->delete();
        return redirect()->back();
    }
}
