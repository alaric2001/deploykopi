@extends('layouts.user')
@section('judul', 'Pembelian')
@section('content')
    <div class="pt-[60px] flex flex-col items-center lg:flex lg:justify-center h-screen my-4">
        <a href="/alamat-input" class="mb-2 p-2 bg-primary border rounded-[6px] text-xs font-semibold text-secondary">
            Tambah Alamat
        </a>

        @if($data_alamat->isEmpty())
            <p class="text-gray-600">Anda belum membuat alamat</p>
        @else
        <div class="flex flex-col gap-1 w-[90%]">
            @foreach ($data_alamat as $key => $alamat)
            <div class="mb-2 p-3 bg-white border rounded-[10px]">
                <div class="flex justify-end mr-2">
                    <div class="flex gap-1">
                        <a href="/alamat/{{ $alamat->id }}" class="font-semibold text-[12px] text-yellow-400">Edit</a>
                        <a class="font-semibold text-[12px] text-red-500" href="/delete_alamat/{{ $alamat->id }}" onclick="return confirm('Anda yakin akan menghapus alamat?')">
                            Hapus
                        </a>
                    </div>
                    
                </div>
                
                <div class="flex flex-row mx-2 mb-2 gap-4 items-start">
                    <div class="flex flex-col">
                        <p class="text-sm font-semibold">{{ $alamat->kel }}</p>
                        <p class="text-sm">{{ $alamat->kec }}</p>
                        <p class="text-sm">{{ $alamat->kodepos }}</p>
                        <p class="text-xs pt-2">{{ $alamat->detail}}</p>
                    </div>
                    
                </div>
            </div>
        @endforeach
        </div>
            
        @endif
    </div>
@endsection