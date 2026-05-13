@extends('layouts.user')
@section('judul', 'Detail Pembelian')
@section('content')
    <div class="pt-[76px] flex flex-col items-center lg:flex lg:justify-center h-screen pb-4">
        @if($order_items->isEmpty())
            <p class="text-gray-600">Anda belum memiliki riwayat pembelian.</p>
        @else
        <div class="flex flex-col gap-1 w-[90%] bg-white border rounded-[10px]">
            @foreach ($order_items as $key => $transaksi)
                <div class="mb-2 p-3 ">
                    {{-- <div class="flex justify-end mr-2">
                        <a class="font-semibold text-[12px] text-red-500" href="/delete_cart/{{ $cart->id }}" onclick="return confirm('Anda yakin akan menghapus pesanan?')">
                        Hapus
                        </a>
                    </div> --}}
                    
                    <div class="flex flex-row mx-2 mb-2 gap-4 items-start">
                        <img class="w-[81px] h-[84px] gap-0 opacity-[0px] rounded-xl object-cover" src="{{ asset('images/' . $transaksi->kopi->foto) }}" alt="foto pesanan">
                        <div class="flex flex-col">
                            {{-- <p class="text-xs">{{ $transaksi->transaksi_updated_at }}</p> --}}
                            <p class="text-xs font-semibold">{{ $transaksi->kopi->jenis_kopi }}</p>
                            <div class="flex flex-row gap-1">
                                <p class="text-xs">Harga</p>
                                <p class="font-bold text-xs">Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            @endforeach
            @if ($transaksi_detail->delivery == 'yes')
                <div class="flex flex-row gap-1 px-5 pb-3">
                    <p class="text-xs">Harga Ongkir</p>
                    <p class="font-bold text-xs">
                        @if ($transaksi_detail->alamat->harga_ongkir > 0)
                            Rp {{ $transaksi_detail->alamat->harga_ongkir }}
                        @else
                            Free Ongkir
                        @endif
                        
                    </p>
                </div>
            @else
                
            @endif
        </div>
            
        @endif
    </div>
@endsection