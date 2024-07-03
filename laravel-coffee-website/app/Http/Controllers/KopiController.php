<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Kopi;
use App\Models\Cart;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\RasaKopi;

class KopiController extends Controller
{
    public function index()
    {
        $kopi = Kopi::all();

        // $cartCount = Cart::where('id_user', auth()->id())->count();
        $cartCount = Cart::where('id_user', auth()->id())->whereNull('transaksi_id')->count();
        // return view('layouts.nav_user', ['cartCount' => $cartCount]);
        return view('index_kopi', compact('kopi', 'cartCount'));
    }

    public function tambah(Request $request)
    {
        if ($request->hasFile('gambar_kopi')) {
            $image = $request->file('gambar_kopi');
            // get the extension
            $extension = $image->getClientOriginalExtension();
            // create a new file name
            $new_name = 'kopi_'.time().'.'.$extension;
            // move file to public/images and use $new_name
            $image->move(public_path('images'), $new_name);

            Kopi::create([
                'jenis_kopi' => $request->jenis_kopi,
                'stok' => $request->stok_kopi,
                'harga' => $request->harga_kopi,
                'deskripsi' => $request->deskripsi,
                'foto' => $new_name,
            ]);
        }
        
        // Redirect ke rute /cart setelah item berhasil ditambahkan ke keranjang
        return redirect()->back()->with('success', 'Item added to cart');
    }

    // Method untuk mengupdate datakopi
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'rasa' => 'required|string|max:255',
        //     'nama_kopi' => 'required|exists:kopi,id',
        // ]);

        if ($request->hasFile('gambar_kopi')) {
            $image = $request->file('gambar_kopi');
            // get the extension
            $extension = $image->getClientOriginalExtension();
            // create a new file name
            $new_name = 'kopi_'.time().'.'.$extension;
            // move file to public/images and use $new_name
            $image->move(public_path('images'), $new_name);

            $kopi = Kopi::findOrFail($id);
            $kopi->jenis_kopi = $request->jenis_kopi;
            $kopi->stok = $request->stok_kopi;
            $kopi->harga = $request->harga_kopi;
            $kopi->deskripsi = $request->deskripsi ? $request->deskripsi : $kopi->deskripsi;
            $kopi->foto = $new_name;
            $kopi->save();
        } else{
            $kopi = Kopi::findOrFail($id);
            $kopi->jenis_kopi = $request->jenis_kopi;
            $kopi->stok = $request->stok_kopi;
            $kopi->harga = $request->harga_kopi;
            $kopi->deskripsi = $request->deskripsi ? $request->deskripsi : $kopi->deskripsi;
            // $kopi->foto = $kopi->foto;
            $kopi->save();
        }

        

        return redirect()->back()->with('success', 'Data rasa kopi berhasil diupdate.');
    }

    public function dashboard()
    {
        $totalPrice = Transaksi::sum('total_price');
        $totalTransaksi = Transaksi::count();
        $totalUsers = User::count();

        // Mengambil data kopi yang telah terorder
        $kopiOrders = Cart::with('kopi')->whereNotNull('transaksi_id')
        ->whereHas('transaksi', function ($query) {
            $query->whereNotNull('bukti_payment');
        })->selectRaw('kopi_id, SUM(quantity) as total_quantity')
        ->groupBy('kopi_id')->get();

        // Menyiapkan data untuk pie chart
        $kopiLabels = $kopiOrders->pluck('kopi.jenis_kopi');
        $kopiQuantities = $kopiOrders->pluck('total_quantity');

        // Mengambil data pesanan kopi per hari
        $ordersPerDay = Cart::select(
            DB::raw('DATE(tbl_transaksi.created_at) as date'),
            'kopi_id',
            DB::raw('SUM(quantity) as total_quantity')
        )
        ->join('tbl_transaksi', 'tbl_cart.transaksi_id', '=', 'tbl_transaksi.id')
        ->whereNotNull('tbl_cart.transaksi_id')
        ->whereNotNull('tbl_transaksi.bukti_payment')
        ->where('tbl_transaksi.created_at', '>=', now()->subDays(30)) //30 hari
        ->groupBy('date', 'kopi_id')
        ->orderBy('date')
        ->get();

        // Inisialisasi array tanggal untuk 30 hari terakhir
        $dates = [];
        for ($i = 29; $i >= 0; $i--) {
            $dates[now()->subDays($i)->format('Y-m-d')] = 0;
        }

        // Format data untuk chart
        $formattedData = [];
        // foreach ($ordersPerDay as $order) {
        //     $formattedData[$order->kopi_id]['dates'][] = $order->date;
        //     $formattedData[$order->kopi_id]['quantities'][] = $order->total_quantity;
        // }
        foreach ($kopiOrders as $kopiOrder) {
            $kopiId = $kopiOrder->kopi_id;
            $formattedData[$kopiId] = ['dates' => array_keys($dates), 'quantities' => array_values($dates)];
    
            foreach ($ordersPerDay as $order) {
                if ($order->kopi_id == $kopiId) {
                    $formattedData[$kopiId]['quantities'][array_search($order->date, $formattedData[$kopiId]['dates'])] = $order->total_quantity;
                }
            }
        }

        // Mengambil jenis kopi untuk label
        $kopiNames = Kopi::whereIn('id', $kopiOrders->pluck('kopi_id'))->pluck('jenis_kopi', 'id');

        return view('admin.main', compact('totalPrice', 'totalTransaksi', 'totalUsers', 'kopiLabels', 'kopiQuantities', 'formattedData', 'kopiNames'));

        // return view('admin.main', compact('totalPrice', 'totalTransaksi', 'totalUsers', 'kopiLabels', 'kopiQuantities'));
    }

    public function datakopiadmin()
    {
        $kopi = Kopi::all();
        return view('admin/datakopi/index', compact('kopi'));
    }

    public function detail($id)
    {
        $detail_kopi = Kopi::find($id);
        // $cartCount = Cart::where('id_user', auth()->id())->count();
        $data_rasa = RasaKopi::where('kopi_id', $id)->get();

        // dd($data_rasa);
        $tidakada_bukti_payment = Transaksi::where('id_user', auth()->id())->whereNull('bukti_payment')->first();
        return view('user.detailkopi', compact('detail_kopi', 'data_rasa', 'tidakada_bukti_payment'));
    }

    public function hapus($id)
    {
        $kopi =Kopi::find($id);
        $kopi->delete();
        return redirect()->back();
    }
}
