<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Kopi;
use App\Models\Cart;
use App\Models\Transaksi;
use App\Models\User;
// use App\Models\RasaKopi;
use App\Models\JenisKopi;
use App\Models\RawJenisKopi;
use App\Models\RawIngredient;
use App\Models\Ingredient;

class KopiController extends Controller
{
    public function index()
    {
        // $kopi = Kopi::all();
        $kopi = Kopi::with('jeniskopi', 'ingredient')->get();
        // $jeniskopi = JenisKopi::all();
        
        $jeniskopi = JenisKopi::all()->keyBy('id');
        // $cartCount = Cart::where('id_user', auth()->id())->count();
        $cartCount = Cart::where('id_user', auth()->id())->whereNull('transaksi_id')->count();
        // return view('layouts.nav_user', ['cartCount' => $cartCount]);
        return view('index_kopi', compact('kopi', 'cartCount'));
    }

    public function dashboard(Request $request)
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
        //Pluck berfungsi utk mengambil nilai dari kolom tertentu dalam sebuah koleksi data
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

        // return view('admin.main', compact('totalPrice', 'totalTransaksi', 'totalUsers', 'kopiLabels', 'kopiQuantities'));
    }

    public function detail($id)
    {
        // $detail_kopi = Kopi::find($id);

        // Mengambil kopi dengan id dan relasi ingredient
        $detail_kopi = Kopi::where('id', $id)->with('ingredient')->first(); 
        
        $data_jeniskopi = JenisKopi::where('kopi_id', $id)->with('raw_jeniskopi')->get();
        $data_ingredient = Ingredient::where('kopi_id', $id)->with('raw_ingredient')->get();

        $tidakada_bukti_payment = Transaksi::where('id_user', auth()->id())->whereNull('bukti_payment')->first();
        
        return view('user.detail_kopi.detailkopi', compact('detail_kopi', 'data_jeniskopi', 'tidakada_bukti_payment', 'data_ingredient'));
    }

    public function datakopiadmin()
    {
        $kopi = Kopi::all();
        return view('admin/datakopi/index', compact('kopi'));
    }

    public function tambah(Request $request)
    {
        if ($request->hasFile('gambar_kopi')) {
            $image = $request->file('gambar_kopi');
            $extension = $image->getClientOriginalExtension(); // get the extension
            $new_name = 'kopi_'.time().'.'.$extension;// create a new file name
            $image->move(public_path('images'), $new_name);// move file to public/images and use $new_name

            $data = [
                'jenis_kopi' => $request->jenis_kopi,
                'stok' => $request->stok_kopi,
                'diskon' => $request->diskon_kopi ?? 0, // Menggunakan null coalescing operator
                'harga' => $request->harga_kopi,
                'deskripsi' => $request->deskripsi,
                'foto' => $new_name,
            ];
            
            if ($request->diskon_kopi) {
                $data['harga_diskon'] = $request->harga_kopi * (1 - $request->diskon_kopi / 100);
            }
            
            Kopi::create($data);
            
            // Kopi::create([
            //     'jenis_kopi' => $request->jenis_kopi,
            //     'stok' => $request->stok_kopi,
            //     'diskon' => $request->diskon_kopi,
            //     'harga' => $request->harga_kopi,
            //     'deskripsi' => $request->deskripsi,
            //     'foto' => $new_name,
            // ]);
        }
        return redirect()->back()->with('success', 'Menu Kopi Berhasil ditambah');
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
            $extension = $image->getClientOriginalExtension(); // get the extension
            $new_name = 'kopi_'.time().'.'.$extension; // create a new file name
            $image->move(public_path('images'), $new_name);// move file to public/images and use $new_name

        } else{
            // Mengambil nama gambar yang sudah ada jika tidak ada gambar baru diupload
            $new_name = Kopi::findOrFail($id)->foto;
            // $kopi = Kopi::findOrFail($id);
            // $kopi->jenis_kopi = $request->jenis_kopi;
            // $kopi->stok = $request->stok_edit;
            // $kopi->diskon = $request->diskon_edit;
            // $kopi->harga = $request->harga_kopi;
            // $kopi->deskripsi = $request->deskripsi ? $request->deskripsi : $kopi->deskripsi;
            // // $kopi->foto = $kopi->foto;
            // $kopi->save();
        }

        $kopi = Kopi::findOrFail($id);
        $kopi->jenis_kopi = $request->jenis_kopi;
        $kopi->stok = $request->stok_edit;
        $kopi->diskon = $request->diskon_edit;
        $kopi->harga = $request->harga_kopi;
        $kopi->deskripsi = $request->deskripsi ?? $kopi->deskripsi;
        $kopi->foto = $new_name;

        // Menghitung harga diskon jika ada diskon yang diberikan
        if ($request->diskon_edit) {
            $kopi->harga_diskon = $request->harga_kopi * (1 - $request->diskon_edit / 100);
        } else {
            $kopi->harga_diskon = null; // Atur harga diskon menjadi null jika tidak ada diskon
        }

        $kopi->save();

        return redirect()->back()->with('success', 'Data kopi berhasil diupdate.');
    }

    public function hapus($id)
    {
        $kopi =Kopi::find($id);
        $kopi->delete();
        return redirect()->back();
    }
}
