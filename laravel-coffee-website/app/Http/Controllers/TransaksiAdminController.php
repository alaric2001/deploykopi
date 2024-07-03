<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Kopi;
use App\Models\Cart;
use App\Models\Transaksi;

class TransaksiAdminController extends Controller
{
    public function orderlist_admin()
    {
        $transaksi_data = Transaksi::all();
        return view('admin.order.index', ['transaksi_data' => $transaksi_data]);

        // if(request()->expectsJson()) {
        //     return response()->json(['transaksi_data' => $transaksi_data]);
        // }
        
        // return view('admin.order.index', compact('transaksi_data'));
        // Mengembalikan data dalam format JSON
    }

    public function data_order_admin(){

        // $transaksi_data = Transaksi::all()->map(function ($transaksi) {
        //     $transaksi->created_at = $transaksi->created_at->format('Y-m-d'); // Memformat tanggal menjadi hanya tanggal
        //     return $transaksi;
        // });
    
        // return response()->json(['transaksi_data' => $transaksi_data]);

        // $transaksi_data = Transaksi::all();
        $transaksi_data = Transaksi::orderBy('created_at', 'desc')->get();
        return response()->json(['transaksi_data' => $transaksi_data]);

        //     $transaksi_data = Transaksi::orderByRaw("
    //     CASE 
    //         WHEN bukti_payment IS NOT NULL AND order_telah_diantar = 'Belum diantar' THEN 1
    //         ELSE 2
    //     END
    // ")->get();
    }

    public function detail($id)
    {
        $transaksi_detail = Transaksi::find($id);
        // Ambil data keranjang yang terkait dengan transaksi_detail tertentu
        $order_items = Cart::where('transaksi_id', $id)->get();
        // dd($order_items);
        return view('admin.order.detail_order', compact('transaksi_detail','order_items'));
    }

    Public function delivered($id)
    {
        // Cari data transaksi berdasarkan ID
        $transaksi = Transaksi::findOrFail($id);

        // Ubah nilai kolom order_telah_diantar menjadi "Sudah diantar"
        $transaksi->update([
            'order_telah_diantar' => 'Sudah diantar'
        ]);

        // Redirect kembali ke halaman sebelumnya atau halaman tertentu
        return redirect()->back()->with('success', 'Status pesanan telah diubah menjadi "Sudah diantar"');
    }

    public function count_undelivered()
    {
        // if(Auth::id()){
            // $count = Cart::where('id_user', auth()->id())->count();

        $count = Transaksi::where('order_telah_diantar', 'Belum diantar')
                ->whereNotNull('bukti_payment')->count();

                                // Debugging log
        \Log::info('Undelivered count: ' . $count);

        return response()->json(['count' => $count]);
    }
}
