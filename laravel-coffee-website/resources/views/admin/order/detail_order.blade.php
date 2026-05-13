@extends('layouts/admin')

@section('admin-content')
<div class="admin-container">
    <p class="text-2xl font-semibold">Customer Order</p>
    <div class="flex flex-col">
        <p class="text-lg font-semibold pb-1">{{ $transaksi_detail->name }} Order Detail </p>
        @if ($transaksi_detail->delivery == 'yes')
            <div class="font-semibold flex flex-row gap-1 items-center">
                Delivery Order<i class="material-icons text-secondary">motorcycle</i>
            </div>
            <div class="flex flex-row">
                <p class="text-sm font-semibold">{{ $transaksi_detail->alamat->kel }}</p>
                <p class="text-sm">, {{ $transaksi_detail->alamat->kec }}</p>
                <p class="text-sm">, {{ $transaksi_detail->alamat->kodepos }}.</p>
            </div>
            <p class="text-xs">Detail Alamat : {{ $transaksi_detail->alamat->detail}}</p>
        @else
            <p class="font-medium">Takeaway Order</p>
        @endif
        
    </div>
    
    <div class="">
        <table class="font-sans w-full">
            <thead>
                <tr class="bg-primary">
                    <th class="w-1">No</th>
                    <th>Items</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order_items as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <div class="flex items-center gap-4">
                            <img class="w-20 h-20 object-cover rounded-md" src="{{ asset('images/' . $item->kopi->foto) }}" alt="coffe image">
                            <div class="flex flex-col">
                                <p class="font-medium">{{ $item->kopi->jenis_kopi }}</p>
                                {{-- <p class="text-xs text-secondary">Note: </p> --}}
                                @if ($item->rasakopi && $item->rasakopi->nama_rasa)
                                    <p class="rasa-button mr-1 text-xs text-secondary">Rasa - {{ $item->rasakopi->nama_rasa }}</p>
                                @endif
                            </div>
                            
                        </div>
                    </td>
                    <td class="w-24">
                        <div class="flex justify-center font-semibold">
                            {{ $item->quantity }}
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection