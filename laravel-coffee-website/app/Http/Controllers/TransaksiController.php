<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Models\Kopi;
use App\Models\Cart;
use App\Models\Transaksi;
use App\Models\PaymentMethod;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::id()){
            $kopi = Kopi::all();
            $cart_data = Cart::where('id_user', auth()->id())->whereNull('transaksi_id')->get();
            // $payment_method = PaymentMethod::all();
            $jenis = $request->input('jenis'); // Mendapatkan parameter filter dari request
            if($jenis) {
                $payment_method = PaymentMethod::where('jenis', $jenis)->get();
            } else {
                $payment_method = PaymentMethod::all();
            }
    
            // Menghitung total pembelian untuk setiap pengguna
            $cart_total = Cart::select('id_user', DB::raw('SUM(jumlah) as total_amount'))
            ->where('id_user', auth()->id())->whereNull('transaksi_id')
            ->groupBy('id_user')->get();
            
            // Mengakses total_amount dari objek pertama (atau satu-satunya) dalam kumpulan
            $total_amount = $cart_total->isEmpty() ? 0 : $cart_total->first()->total_amount;
            // dd($total_amount);
    
            $cartCount = Cart::where('id_user', auth()->id())->whereNull('transaksi_id')->count();
            // return view('layouts.nav_user', ['cartCount' => $cartCount]);
    
            $transaksi = Transaksi::where('id_user', auth()->id())->whereNull('bukti_payment')->first();
            if($transaksi)
            {
                return view('user.checkout', compact('kopi', 'cart_data','payment_method' , 'total_amount', 'cartCount', 'transaksi'));
            }
            else{
                return redirect('/');
            }
        }
        else{
            return redirect('/login');
        }
        
    }

    public function add_order(Request $request)
    {
        if(Auth::id()){
            // Mendapatkan data kopi dari database
            $kopi = Kopi::find($request->kopi_id);
            if (!$kopi) {
                return redirect()->back()->with('error', 'Kopi not found');
            }

            // Mengatur nilai default quantity menjadi 1 jika tidak disertakan dalam permintaan
            $quantity = $request->quantity ?? 1;
            $total = $quantity * $kopi->harga;

            // Buat atau perbarui keranjang belanja pengguna
            Cart::create([
                'id_user' => Auth::id(), 
                'kopi_id' => $request->kopi_id,
                'quantity' => $quantity, 
                'jumlah' => $total
            ]);
            Transaksi::create([
                'name' => Auth::user()->name_user,
                'id_user' => Auth::id(), 
            ]);
            
            // Redirect ke rute /cart setelah item berhasil ditambahkan ke keranjang
            return redirect('/checkout');
        }
        else{
            return redirect('/login');
        }
        // Validasi request
        $request->validate([
            'kopi_id' => 'required|exists:tbl_kopi,id',
            'quantity' => 'required|integer|min:1',
        ]);
    }

    public function addOrder_deletedItem(Request $request)
    {
        if(Auth::id()){
            // Validasi request
            $request->validate([
                'kopi_id' => 'required|exists:tbl_kopi,id',
                'quantity' => 'required|integer|min:1',
            ]);

            // Mendapatkan data kopi dari database
            $kopi = Kopi::find($request->kopi_id);
            if (!$kopi) {
                return redirect()->back()->with('error', 'Kopi not found');
            }
            
            // $quantity = $request->quantity ?? 1;
            // $total = $quantity * $kopi->harga;

            // Buat atau perbarui keranjang belanja pengguna
            Cart::create([
                'id_user' => Auth::id(),
                'kopi_id' => $request->kopi_id,
                'rasa_kopi_id' => $request->rasakopi,
                'quantity' => $request->quantity,
                'jumlah' => $request->total,
            ]);
            
            // Redirect ke rute /cart setelah item berhasil ditambahkan ke keranjang
            return redirect('/checkout')->with('success', 'Item added to cart');
        }
        else{
            return redirect('/login');
        }
    }

    public function cart_order(Request $request)
    {
        if(Auth::id()){
            Transaksi::create([
                'name' => Auth::user()->name_user,
                'id_user' => Auth::id(), 
            ]);
            
            // Redirect ke rute /cart setelah item berhasil ditambahkan ke keranjang
            return redirect('/checkout')->with('success', 'Item added to cart');
        }
        else{
            return redirect('/login');
        }
    }

    public function checkout_order(Request $request)
    {
        if(Auth::id()){
            
            
            // Validasi request
            $request->validate([
                // 'kopi_id' => 'required|exists:tbl_kopi,id',
                // 'quantity' => 'required|integer|min:1',
                'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ],
            [
                'bukti_bayar.image' => 'Bukti bayar harus jpg/jpeg/png',
                'bukti_bayar.mimes' => 'Bukti bayar harus jpg/jpeg/png',
                'bukti_bayar.max' => 'Ukuran file harus < 2MB'
            ]);

            $transaksi = Transaksi::where('id_user', auth()->id())->whereNull('bukti_payment')->first();
            
            // $imageName = $request->file('bukti_bayar');
            if ($request->hasFile('bukti_bayar')) {
                $image = $request->file('bukti_bayar');
                // get the extension
                $extension = $image->getClientOriginalExtension();
                // create a new file name
                $new_name = time().'.'.$extension;
                // move file to public/images/new and use $new_name
                $image->move(public_path('images/bukti_bayar'), $new_name);
        
                $transaksi->update([
                    'bukti_payment' => $new_name,
                    'dine_in' => $request->order, 
                    'no_meja' => $request->nomor_meja, 
                    'total_price' => $request->total_amount
                ]);
            }

            Cart::where('id_user', Auth::id())->whereNull('transaksi_id')
            ->update(['transaksi_id' => $transaksi->id]);
            
            // $existingCart = Cart::where('id_user', Auth::id())->whereNull('transaksi_id')->first();
            // $existingCart->update([
            //     'transaksi_id' => $transaksi->id
            // ]);

            
            // Redirect ke rute /cart setelah item berhasil ditambahkan ke keranjang
            return redirect('/')->with('success', 'Item added to cart');
        }
        else{
            return redirect('/login');
        }


        // Transaksi::update([
            //     'bukti_paymet' => $request->bukti_bayar,
            //     // 'bukti_paymet' =>'pakbos1.jpg',
            //     'dine_in' => $request->order, 
            //     'no_meja' => $request->nomor_meja, 
            //     'total_price' => $request->total_amount
            // ]);

            // Cek apakah ada keranjang belanja yang belum memiliki transaksi_id
            
            // $existingCart = Cart::where('id_user', Auth::id())->whereNull('transaksi_id')
            // ->where('kopi_id', $request->kopi_id)->first();
    }
}
