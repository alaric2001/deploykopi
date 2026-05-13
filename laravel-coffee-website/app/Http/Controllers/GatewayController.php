<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kopi; // Import model Kopi
use App\Models\Cart;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\JenisKopi;
use App\Models\RawJenisKopi;
use App\Models\RawIngredient;
use Illuminate\Support\Facades\DB;

class GatewayController extends Controller
{
    public function door(Request $request)
    {
        if(Auth::check())
        {
            $role=Auth()->user()->role;
            if($role=='user')
            {
                $kopi = Kopi::with('jeniskopi', 'ingredient')->get();
                // $jeniskopi = JenisKopi::all()->keyBy('id');
                $cartCount = Cart::where('id_user', auth()->id())->whereNull('transaksi_id')->count();
                return view('index_kopi', compact('kopi', 'cartCount'));
            }
            else if($role=='pemilik')
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
        
                // Mendapatkan bulan dan tahun dari request atau menggunakan default
                $bulan = $request->input('bulan', now()->format('m'));
                $tahun = $request->input('tahun', now()->format('Y'));
        
                // Mengambil data pesanan kopi per hari berdasarkan bulan dan tahun
                $ordersPerDay = Cart::select(
                    DB::raw('DATE(tbl_transaksi.created_at) as date'),
                    'kopi_id',
                    DB::raw('SUM(quantity) as total_quantity')
                )
                ->join('tbl_transaksi', 'tbl_cart.transaksi_id', '=', 'tbl_transaksi.id')
                ->whereNotNull('tbl_cart.transaksi_id')
                ->whereNotNull('tbl_transaksi.bukti_payment')
                ->whereYear('tbl_transaksi.created_at', $tahun)
                ->whereMonth('tbl_transaksi.created_at', $bulan)
                ->groupBy('date', 'kopi_id')->orderBy('date')
                ->get();
        
                // Inisialisasi array tanggal untuk bulan yang dipilih
                $dates = [];
                $startOfMonth = now()->setDate($tahun, $bulan, 1)->startOfMonth();
                $endOfMonth = now()->setDate($tahun, $bulan, 1)->endOfMonth();
        
                for ($date = $startOfMonth; $date <= $endOfMonth; $date->addDay()) {
                    $dates[$date->format('Y-m-d')] = 0;
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
        
                // Mengambil semua bulan dan tahun untuk dropdown
                $months = [
                    '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April',
                    '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August',
                    '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
                ];
        
                $years = range(now()->year - 5, now()->year); // Mengambil 5 tahun terakhir
        
                // Data stok kopi
                $kopiStocks = Kopi::select('jenis_kopi', 'stok')->get();
                $kopiStockLabels = $kopiStocks->pluck('jenis_kopi');
                $kopiStockQuantities = $kopiStocks->pluck('stok');

                // Data Chart stok Jenis Kopi
                $rawjenikkopi = RawJenisKopi::select('nama', 'stok')->get();
                $labelstokjeniskopi = $rawjenikkopi->pluck('nama');
                $stok_jenikkopi = $rawjenikkopi->pluck('stok');

                // Data Chart stok Ingredient
                $rawingredient = RawIngredient::select('nama', 'stok')->get();
                $labelstokingredient = $rawingredient->pluck('nama');
                $stok_ingredient = $rawingredient->pluck('stok');

                return view('admin.mainpage.main', compact(
                    'totalPrice', 'totalTransaksi', 'totalUsers', 'kopiLabels', 'kopiQuantities', 
                    'formattedData', 'kopiNames', 'bulan', 'tahun', 'months', 'years',
                    'kopiStockLabels', 'kopiStockQuantities', 'labelstokjeniskopi', 'stok_jenikkopi',
                    'stok_ingredient', 'labelstokingredient'
                ));
            }
            // {
            //     $totalPrice = Transaksi::sum('total_price');
            //     $totalTransaksi = Transaksi::count();
            //     $totalUsers = User::count();

            //     // Mengambil data kopi yang telah terorder
            //     $kopiOrders = Cart::with('kopi')->whereNotNull('transaksi_id')
            //     ->whereHas('transaksi', function ($query) {
            //         $query->whereNotNull('bukti_payment');
            //     })->selectRaw('kopi_id, SUM(quantity) as total_quantity')
            //     ->groupBy('kopi_id')->get();

            //     // Menyiapkan data untuk pie chart
            //     $kopiLabels = $kopiOrders->pluck('kopi.jenis_kopi');
            //     $kopiQuantities = $kopiOrders->pluck('total_quantity');

            //     // Mengambil data pesanan kopi per hari
            //     $ordersPerDay = Cart::select(
            //         DB::raw('DATE(tbl_transaksi.created_at) as date'),
            //         'kopi_id',
            //         DB::raw('SUM(quantity) as total_quantity')
            //     )
            //     ->join('tbl_transaksi', 'tbl_cart.transaksi_id', '=', 'tbl_transaksi.id')
            //     ->whereNotNull('tbl_cart.transaksi_id')->whereNotNull('tbl_transaksi.bukti_payment')
            //     ->groupBy('date', 'kopi_id')->orderBy('date')->get();

            //     // Format data untuk chart
            //     $formattedData = [];
            //     foreach ($ordersPerDay as $order) {
            //         $formattedData[$order->kopi_id]['dates'][] = $order->date;
            //         $formattedData[$order->kopi_id]['quantities'][] = $order->total_quantity;
            //     }

            //     // Mengambil jenis kopi untuk label
            //     $kopiNames = Kopi::whereIn('id', $kopiOrders->pluck('kopi_id'))->pluck('jenis_kopi', 'id');

            //     return view('admin.main', compact('totalPrice', 'totalTransaksi', 'totalUsers', 'kopiLabels', 'kopiQuantities', 'formattedData', 'kopiNames'));
            // }
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
