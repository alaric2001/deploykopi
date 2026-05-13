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
use App\Models\Alamat;
use App\Models\RawJenisKopi;
use App\Models\JenisKopi;
use App\Models\RawIngredient;
use App\Models\Ingredient;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::id()){
            $kopi = Kopi::all();
            $cart_data = Cart::where('id_user', auth()->id())->whereNull('transaksi_id')->get();
            $alamat = Alamat::where('id_user', Auth::id())->get();
            $jenis = $request->input('jenis'); // Mendapatkan parameter filter dari request
            if($jenis) {
                $payment_method = PaymentMethod::where('jenis', $jenis)->get();
            } else {
                $payment_method = PaymentMethod::all();
            }
            // Mengambil jenis unik
            $unique_payment_methods = PaymentMethod::select('jenis')->distinct()->get();
    
            // Menghitung total pembelian untuk setiap pengguna
            $cart_total = Cart::select('id_user', DB::raw('SUM(jumlah) as total_amount'))
            ->where('id_user', auth()->id())->whereNull('transaksi_id')
            ->groupBy('id_user')->get();
            
            // Mengakses total_amount dari objek pertama (atau satu-satunya) dalam kumpulan
            $total_amount = $cart_total->isEmpty() ? 0 : $cart_total->first()->total_amount;
    
            $cartCount = Cart::where('id_user', auth()->id())->whereNull('transaksi_id')->count();
            // return view('layouts.nav_user', ['cartCount' => $cartCount]);
    
            $transaksi = Transaksi::where('id_user', auth()->id())->whereNull('bukti_payment')->first();
            if($transaksi)
            {
                return view('user.checkout', compact('unique_payment_methods','kopi', 'cart_data','payment_method' , 'total_amount', 'cartCount', 'transaksi', 'alamat'));
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
                'jenis_kopi_id' => $request->jeniskopi,
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
                'jenis_kopi_id' => $request->jeniskopi,
                'quantity' => $request->quantity,
                'jumlah' => $request->total,
            ]);
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

            $cartItems = json_decode($request->cart_items, true); // Decode JSON to array

            // Update each cartitem
            // foreach ($cartItems as $item) {
            //     Cart::where('id', $item['id'])->update([
            //         'quantity' => $item['quantity'],
            //         'jumlah' => $item['total'],
            //     ]);
            // }
            if (is_array($cartItems)) {
                foreach ($cartItems as $item) {
                    Cart::where('id', $item['id'])->update([
                        'quantity' => $item['quantity'],
                        'jumlah' => $item['total'],
                    ]);
                }
            } else {
                return redirect('/checkout')->with('success', 'Berhasil');
            }
            // return redirect('/checkout')->with('success', 'Berhasil');
        }
        else{
            return redirect('/login');
        }
    }

    public function cart_update_and_order(Request $request)
    {
        if(Auth::id()){
            $cartItems = json_decode($request->cart_items, true);
            // Update each cart item
            foreach ($cartItems as $item) {
                Cart::where('id', $item['id'])->update([
                    'quantity' => $item['quantity'],
                    'jumlah' => $item['total'],
                ]);
            }
            return redirect('/checkout')->with('success', 'Berhasil');
        }
        else{
            return redirect('/login');
        }
    }


    public function checkout_order(Request $request)
    {
        if(Auth::id()){
            $request->validate([ // Validasi request
                'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ],
            [
                'bukti_bayar.image' => 'Bukti bayar harus jpg/jpeg/png',
                'bukti_bayar.mimes' => 'Bukti bayar harus jpg/jpeg/png',
                'bukti_bayar.max' => 'Ukuran file harus < 2MB'
            ]);

            $transaksi = Transaksi::where('id_user', auth()->id())->whereNull('bukti_payment')->first();
            
            if ($request->hasFile('bukti_bayar')) {
                $image = $request->file('bukti_bayar');
                $extension = $image->getClientOriginalExtension(); // get the extension
                $new_name = time().'.'.$extension;// create a new file name
                $image->move(public_path('images/bukti_bayar'), $new_name); // move file to public/images/new and use $new_name
        
                $transaksi->update([
                    'name' => Auth::user()->name_user,
                    'order_telah_diantar' => 'Belum diantar',
                    'bukti_payment' => $new_name,
                    'delivery' => $request->order, 
                    'id_alamat' => $request->alamat, 
                    'total_price' => $request->total_amount
                ]);
            }

            $cartItems = Cart::where('id_user', Auth::id())->whereNull('transaksi_id')->get();
            foreach ($cartItems as $cart) {
                $kopi = Kopi::find($cart->kopi_id);
                //Mencari data jeniskopi berdasarkan jenis_kopi_id yang tertera pada data Cart
                $jeniskopimenu = JenisKopi::find($cart->jenis_kopi_id);
                $ingredientmenu = Ingredient::where('kopi_id', $cart->kopi_id)->get();

                if ($jeniskopimenu) { // Pastikan $jeniskopimenu tidak null
                    
                    //Mencari data rawjeniskopi berdasarkan id_rawjeniskopi kopi yang tertera pada data JenisKopi
                    $jeniskopistok = RawJenisKopi::find($jeniskopimenu->id_rawjeniskopi);
                    
                    if ($kopi->stok >= $cart->quantity) {
                        $kopi->stok -= $cart->quantity;
                        $jeniskopistok->stok -= $cart->quantity;
                        
                        foreach ($ingredientmenu as $ingredient) {
                            $ingredientstok = RawIngredient::find($ingredient->rawingredient_id);
                            if ($ingredientstok) {
                                $ingredientstok->stok -= $cart->quantity;
            
                                if ($ingredientstok->stok <= 0) {
                                    Ingredient::where('rawingredient_id', $ingredient->rawingredient_id)->update(['available' => 2]);
                                }
                                $ingredientstok->save();
                            }
                        }

                        if ( $jeniskopistok->stok - $cart->quantity <= 0) {
                            JenisKopi::where('id_rawjeniskopi', $jeniskopimenu->id_rawjeniskopi)->update(['ready' => 2]);
                        }
                        $kopi->save();
                        $jeniskopistok->save();
                    } else {
                        return redirect('/')->with('error', 'Stok kopi tidak mencukupi untuk pesanan Anda.');
                    }
                } else {
                    return redirect('/')->with('error', 'Jenis kopi tidak ditemukan untuk pesanan Anda.');
                }
            }

            Cart::where('id_user', Auth::id())->whereNull('transaksi_id')
            ->update(['transaksi_id' => $transaksi->id]);
            
            // $existingCart = Cart::where('id_user', Auth::id())->whereNull('transaksi_id')->first();
            // $existingCart->update([
            //     'transaksi_id' => $transaksi->id
            // ]);
            return redirect('/')->with('success', 'Pesanan anda sedang diproses');
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

    public function history_pembelian(Request $request)
    {
        // Ambil semua transaksi untuk pengguna yang sedang login
        $transaksi_data = Transaksi::where('id_user', Auth::id())
                        ->orderBy('updated_at', 'desc')->get();

        // Format tanggal dan ambil item pesanan
        $transaksi_data->each(function($item) {
            $item->transaksi_updated_at = Carbon::parse($item->updated_at)->format('d M Y');
            $item->order_items = Cart::where('transaksi_id', $item->id)->get();
        });
        return view('user.history_pembelian.index', compact('transaksi_data'));

        // $transaksi_data = Cart::where('tbl_cart.id_user', Auth::id())
        //                 ->join('tbl_transaksi', 'tbl_cart.transaksi_id', '=', 'tbl_transaksi.id')
        //                 ->select('tbl_cart.*', 'tbl_transaksi.bukti_payment', 'tbl_transaksi.updated_at as transaksi_updated_at', 'tbl_transaksi.order_telah_diantar')
        //                 ->orderBy('tbl_transaksi.updated_at', 'desc') // Mengurutkan berdasarkan transaksi_updated_at terbaru
        //                 ->get();
    }

    public function detail_history_pembelian($id)
    {
        $transaksi_detail = Transaksi::find($id);
        $order_items = Cart::where('transaksi_id', $id)->get();
        return view('user.history_pembelian.detail', compact('transaksi_detail','order_items'));
    }
}
