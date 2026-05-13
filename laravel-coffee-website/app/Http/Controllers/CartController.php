<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Kopi; // Import model Kopi
// use App\Models\RasaKopi;
use App\Models\JenisKopi;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index_cart()
    {
        // $cart_data = Cart::all();
        // $cart_data = Cart::with('kopi')->get();
        // $cart_data = Cart::where('id_user', auth()->id())->get();
        // $cartCount = Cart::where('id_user', auth()->id())->count();
        // $cartCount = Cart::where('id_user', auth()->id())->whereNull('transaksi_id')->count();
        $tidakada_bukti_payment = Transaksi::where('id_user', auth()->id())->whereNull('bukti_payment')->first();
        $cart_data = Cart::where('id_user', Auth::id())->whereNull('transaksi_id')->with('kopi', 'jeniskopi')->get();
        // $cart_data = Cart::where('id_user', Auth::id())->whereNull('transaksi_id')->with('kopi', 'rasakopi')->get();
        return view('user.cart', compact('cart_data', 'tidakada_bukti_payment'));
    }

    public function add_cart(Request $request)
    {

        if(Auth::id()){
            $request->validate([
                'kopi_id' => 'required|exists:tbl_kopi,id',
                'quantity' => 'required|integer|min:1',
                'total' => 'required|numeric|min:0',
            ]);

            // Mendapatkan data kopi dari database
            $kopi = Kopi::find($request->kopi_id);
            if (!$kopi) {
                return redirect()->back()->with('error', 'Kopi not found');
            }

            // Mengatur nilai default quantity menjadi 1 jika tidak disertakan dalam permintaan
            // $quantity = $request->quantity ?? 1;
            // $total = $quantity * $kopi->harga;

            // Buat keranjang belanja pengguna
            Cart::create([
                'id_user' => Auth::id(),
                'kopi_id' => $request->kopi_id,
                // 'rasa_kopi_id' => $request->rasakopi,
                'jenis_kopi_id' => $request->jeniskopi,
                'quantity' => $request->quantity,
                'jumlah' => $request->total,
            ]);

            // Redirect ke rute /cart setelah item berhasil ditambahkan ke keranjang
            return redirect('/cart')->with('success', 'Item added to cart');
        }
        else{
            return redirect('/login');
        }
    }

    public function getCartCount()
    {
        $cartCount = Cart::where('id_user', auth()->id())->whereNull('transaksi_id')->count();
        \Log::info('Undelivered count: ' . $cartCount);
        // dd($cartCount );
        return response()->json(['cartCount' => $cartCount]);
    }

    public function destroy($id)
    {
        $data_cart = Cart::find($id);
        $data_cart->delete();
        return redirect()->back();
    }

    
}
