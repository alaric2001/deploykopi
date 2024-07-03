@extends('layouts/admin')

@section('admin-content')
<div class="admin-container">
    <p class="text-2xl font-semibold">Customer Order</p>
    <p class="text-lg font-bold">{{ $transaksi_detail->name }} Order Detail </p>
    {{-- <div class="flex flex-col text-sm">
        @if ($transaksi_detail->dine_in == 'no')
            <p class="font-medium">Takeaway</p>
        @else
            <div class="flex flex-row">
                <p class="font-medium">Dine In</p>
                <p class="ml-[29px] mr-2">:</p>
                <p>{{ $transaksi_detail->dine_in }}</p>
            </div>
            <div class="flex flex-row">
                <p class="font-medium">No. Table</p>
                <p class="ml-[12px] mr-2">:</p>
                <p>{{ $transaksi_detail->no_meja}}</p>
            </div>
        @endif
        
    </div> --}}
    
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