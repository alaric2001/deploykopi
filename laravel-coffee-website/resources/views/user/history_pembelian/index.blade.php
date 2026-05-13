@extends('layouts.user')
@section('judul', 'History Pembelian')
@section('content')
    <div class="pt-[60px] flex flex-col items-center h-screen mt-4">
        @if($transaksi_data->isEmpty())
            <p class="text-gray-600">Anda belum memiliki riwayat pembelian.</p>
        @else
            <div class="flex flex-col gap-1 w-[90%]">
                @foreach ($transaksi_data as $key => $transaksi)
                    @foreach ($transaksi->order_items as $order_item)
                        <a href="/detail-history-order/{{ $transaksi->id }}" class="mb-2 p-3 bg-white border rounded-[10px]">
                            <div class="flex flex-row mx-2 mb-2 gap-4 items-start">
                                <img class="w-[81px] h-[84px] gap-0 opacity-[0px] rounded-xl object-cover" src="{{ asset('images/' . $order_item->kopi->foto) }}" alt="foto pesanan">
                                <div class="flex flex-col">
                                    <p class="text-xs">{{ $transaksi->transaksi_updated_at }}</p>
                                    {{-- <p class="text-xs font-semibold">{{ $order_item->kopi->jenis_kopi }}</p> --}}
                                    @if ($transaksi->order_telah_diantar == 'Belum diantar')
                                        <p class="font-bold text-xs text-orange-400">Diproses</p>
                                    @elseif ($transaksi->order_telah_diantar == 'Sudah diantar')
                                        <p class="font-bold text-xs text-green-500">Selesai</p>
                                    @else
                                        <p class="font-bold text-xs">Status tidak diketahui</p>
                                    @endif
                                    <div class="flex flex-row gap-1">
                                        <p class="text-xs">Total Belanja</p>
                                        <p class="font-bold text-xs">Rp {{ number_format($transaksi->total_price, 0, ',', '.') }}</p>
                                    </div>
                                    <p class="text-xs flex items-center gap-1 font-semibold">
                                        @if ($transaksi->delivery == 'yes')
                                            <i class="text-base material-icons text-secondary">motorcycle</i>Delivery
                                        @else
                                            <i class="text-base material-icons text-secondary">shopping_basket</i>Takeaway
                                        @endif
                                    </p>
                                </div>
                                
                            </div>
                        </a>
                    @endforeach
                @endforeach
            </div>
        @endif
    </div>
@endsection