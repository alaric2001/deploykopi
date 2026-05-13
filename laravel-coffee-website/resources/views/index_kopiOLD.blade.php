{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Link ke file CSS -->
    <link rel="stylesheet" href="{{ asset('css/kopi.css') }}">

    <title>Kopi Index Page</title>
</head>
<body> --}}
@extends('layouts.user')
@section('judul', 'Home')
@section('content')
    {{-- <center>
        <p class="text-2xl font-bold my-4">Seteguk Kopi</p>
    </center> --}}
    
    <div class="my-4 flex justify-center pt-[80px]">
        <div class="grid-card mx-3 sm:mx-7 sm:w-[1100px] gap-4">
            @foreach ($kopi as $item)
                @if ($jeniskopi->get($item->id)->kopi_id==$item->id)
                    <a class="card relative {{ $item->stok < 1 ? 'pointer-events-none' : '' }}" href="/kopi/{{ $item->id }}">
                        @if($item->stok < 1 || $jeniskopi->get($item->id)->ready == 0)
                            <div class="rounded-lg absolute inset-0 bg-secondary bg-opacity-60 flex items-center justify-center text-white font-bold">
                                Stok Habis
                            </div>
                        @endif
                        <img src="{{ asset('images/' . $item->foto) }}" class="{{ $item->stok < 1 ? 'opacity-30' : '' }} card-img-kopi rounded-t-lg" alt="{{ $item->jenis_kopi }}">
                        <div class="card-body m-2 {{ $item->stok < 1 ? 'opacity-50' : '' }}">
                            <div class="flex items-center gap-1">
                                @if ($item->diskon > 0)
                                    <h3 class="card-title text-sm leading-5">{{ $item->jenis_kopi }}</h3>
                                    <p class="text-xs font-bold text-red-500">-{{ $item->diskon }}%</p>
                                @else
                                    <h3 class="card-title text-sm leading-5">{{ $item->jenis_kopi }}</h3>
                                @endif
                            </div>
                            
                            @if($item->diskon > 0)
                                <div class="flex items-center gap-1">
                                    <p class="card-text text-sm font-bold">
                                        Rp. {{ number_format($item->harga * (1 - $item->diskon / 100), 0, ',', '.') }}
                                    </p>
                                    <s class="text-xs text-gray-400">Rp. {{ number_format($item->harga, 0, ',', '.') }}</s>
                                </div>
                            @else
                                <p class="card-text text-sm font-bold"> Rp. {{ number_format($item->harga, 0, ',', '.') }}</p>
                            @endif

                            {{-- <p class="card-text" style="text-align: justify">{{ $item->deskripsi }}</p> --}}
                            {{-- <b><p class="card-text text-sm">Rp {{ number_format($item->harga, 2) }}</p></b> --}}

                            {{-- <p class="card-text text-[10px]">Stok: {{ $item->stok }}</p> --}}
                            <!-- Tambahan informasi lainnya sesuai kebutuhan -->

                            <!-- Tombol untuk menuju detail jika diperlukan -->
                            {{-- <a href="{{ route('', $item->id) }}" class="btn btn-primary">Lihat Detail</a> --}}
                        </div>
                    </a>
                @else
                    <a class="card relative {{ $item->stok < 1 ? 'pointer-events-none' : '' }}" href="/kopi/{{ $item->id }}">
                        @if($item->stok < 1)
                            <div class="rounded-lg absolute inset-0 bg-secondary bg-opacity-60 flex items-center justify-center text-white font-bold">
                                Stok Habis
                            </div>
                        @endif
                        <img src="{{ asset('images/' . $item->foto) }}" class="{{ $item->stok < 1 ? 'opacity-30' : '' }} card-img-kopi rounded-t-lg" alt="{{ $item->jenis_kopi }}">
                        <div class="card-body m-2 {{ $item->stok < 1 ? 'opacity-50' : '' }}">
                            <div class="flex items-center gap-1">
                                @if ($item->diskon > 0)
                                    <h3 class="card-title text-sm leading-5">{{ $item->jenis_kopi }}</h3>
                                    <p class="text-xs font-bold text-red-500">-{{ $item->diskon }}%</p>
                                @else
                                    <h3 class="card-title text-sm leading-5">{{ $item->jenis_kopi }}</h3>
                                @endif
                            </div>
                            
                            @if($item->diskon > 0)
                                <div class="flex items-center gap-1">
                                    <p class="card-text text-sm font-bold">
                                        Rp. {{ number_format($item->harga * (1 - $item->diskon / 100), 0, ',', '.') }}
                                    </p>
                                    <s class="text-xs text-gray-400">Rp. {{ number_format($item->harga, 0, ',', '.') }}</s>
                                </div>
                            @else
                                <p class="card-text text-sm font-bold"> Rp. {{ number_format($item->harga, 0, ',', '.') }}</p>
                            @endif

                            {{-- <p class="card-text" style="text-align: justify">{{ $item->deskripsi }}</p> --}}
                            {{-- <b><p class="card-text text-sm">Rp {{ number_format($item->harga, 2) }}</p></b> --}}

                            {{-- <p class="card-text text-[10px]">Stok: {{ $item->stok }}</p> --}}
                            <!-- Tambahan informasi lainnya sesuai kebutuhan -->

                            <!-- Tombol untuk menuju detail jika diperlukan -->
                            {{-- <a href="{{ route('', $item->id) }}" class="btn btn-primary">Lihat Detail</a> --}}
                        </div>
                    </a>
            @endif
                
            @endforeach
        </div>
    </div>
@endsection

{{-- </body>
</html> --}}