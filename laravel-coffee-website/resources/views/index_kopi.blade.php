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
    <div class="my-4 flex justify-center pt-[80px]">
        <div class="grid-card mx-3 sm:mx-7 sm:w-[1100px] gap-4">
            @foreach ($kopi as $item)
                @php
                    $kopiid = $item->jeniskopi->first()->kopi_id ?? false; //cek apakah menu memili jenis kopi
                    if ($kopiid) {
                        $allReadyTwo = true;
                        foreach ($item->jeniskopi as $jenis) { //Cek jenis kopi, apakah keduanya habis atau tidak?
                            if ($jenis->ready != 2) { // 1 adalah ready, 2 tidak ready
                                $allReadyTwo = false;
                                break;
                            }
                        }
                        
                        $oneoftwo = $item->ingredient->contains(function($data) {
                        return $data->available == 2;
                        });

                        $isOutOfStock = $item->stok < 1 || $allReadyTwo  || $oneoftwo;
                    }
                    else {
                        $oneoftwo = $item->ingredient->contains(function($data) {
                        return $data->available == 2;
                        });
                        $isOutOfStock = $item->stok < 1 || $oneoftwo;
                    }
                @endphp

                <a class="card relative {{ $isOutOfStock ? 'pointer-events-none' : '' }}" href="/kopi/{{ $item->id }}">
                    @if ($isOutOfStock)
                        <div class="rounded-lg absolute inset-0 bg-secondary bg-opacity-60 flex items-center justify-center text-white font-bold">
                            Stok Habis
                        </div>
                    @endif
                    <img src="{{ asset('images/' . $item->foto) }}" class="{{ $isOutOfStock ? 'opacity-30' : '' }} card-img-kopi rounded-t-lg" alt="{{ $item->jenis_kopi }}">
                    <div class="card-body m-2 {{ $isOutOfStock ? 'opacity-50' : '' }}">
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
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection

{{-- </body>
</html> --}}