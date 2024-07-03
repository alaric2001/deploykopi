<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kopi; // Import model Kopi
use App\Models\Cart;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class GatewayController extends Controller
{
    public function door()
    {
        if(Auth::check())
        {
            $role=Auth()->user()->role;
            if($role=='user')
            {
                $kopi = Kopi::all();
                // $cartCount = Cart::where('id_user', auth()->id())->count();
                $cartCount = Cart::where('id_user', auth()->id())->whereNull('transaksi_id')->count();
                return view('index_kopi', compact('kopi', 'cartCount'));
            }
            else if($role=='admin')
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
                ->whereNotNull('tbl_cart.transaksi_id')->whereNotNull('tbl_transaksi.bukti_payment')
                ->groupBy('date', 'kopi_id')->orderBy('date')->get();

                // Format data untuk chart
                $formattedData = [];
                foreach ($ordersPerDay as $order) {
                    $formattedData[$order->kopi_id]['dates'][] = $order->date;
                    $formattedData[$order->kopi_id]['quantities'][] = $order->total_quantity;
                }

                // Mengambil jenis kopi untuk label
                $kopiNames = Kopi::whereIn('id', $kopiOrders->pluck('kopi_id'))->pluck('jenis_kopi', 'id');

                return view('admin.main', compact('totalPrice', 'totalTransaksi', 'totalUsers', 'kopiLabels', 'kopiQuantities', 'formattedData', 'kopiNames'));
            }
            else
            {
                return redirect()->back()->with('error', 'Invalid user role');
            }
        }
        else{
            return redirect('/');
        }
    }
}
