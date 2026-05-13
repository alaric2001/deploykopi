@extends('layouts.user')
@section('judul', $detail_kopi->jenis_kopi)
@section('content')
    <div class="flex justify-center">
        <div class="h-screen mb-[70px] pt-[80px] bg-white sm:w-[800px] sm:mb-0">
            {{-- mobile layout --}}
            <div class="px-6 flex flex-col sm:hidden bg-white">
                <img class="rounded-lg h-[300px] object-cover" src="{{ asset('images/' . $detail_kopi->foto) }}" alt="foto kopi">
                {{-- <p class="pt-2 text-md">{{ $detail_kopi->jenis_kopi }}</p> --}}
                <div class="flex items-center gap-2 pt-2 ">
                    @if ($detail_kopi->diskon > 0)
                        <p class="text-md">{{ $detail_kopi->jenis_kopi }}</p>
                        <p class="text-xs font-bold text-red-500">-{{ $detail_kopi->diskon }}%</p>
                    @else
                        <p class="text-md">{{ $detail_kopi->jenis_kopi }}</p>
                    @endif
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        {{-- Rp. <span id="total-price">{{ $detail_kopi->harga }}</span> --}}
                        @if($detail_kopi->diskon > 0)
                            <p class="font-semibold text-xl ">
                                Rp. {{ number_format($detail_kopi->harga * (1 - $detail_kopi->diskon / 100), 0, ',', '.') }}
                            </p>
                            <s class="text-xs text-gray-400">
                                Rp. {{ number_format($detail_kopi->harga, 0, ',', '.') }}
                            </s>
                        @else
                            <p class="font-semibold text-xl ">
                                Rp. {{ number_format($detail_kopi->harga, 0, ',', '.') }}
                            </p>
                        @endif
                    </div>
                    <div class="flex items-center ml-4">
                        <button id="decrease-qty" class="bg-primary text-secondary text-sm font-medium px-[9px] py-1 rounded-3xl">-</button>
                        <input type="text" id="quantity" name="quantity" value="1" class="font-medium w-12 h-8 text-center border-none" readonly>
                        <button id="increase-qty" class="bg-secondary text-primary text-sm font-medium px-[8px] py-1 rounded-3xl">+</button>
                    </div>
                </div>
                
                <div class="flex text-xs items-center gap-1 mt-2">
                    <p>Stok {{ $detail_kopi->stok }}</p>
                </div>
                @if($data_jeniskopi->isNotEmpty())
                    <p class="font-semibold pt-4">Jenis Kopi</p>
                    <div class="">
                        @foreach ($data_jeniskopi as $item)
                            @if ($item->ready == 1)
                                <button data-id="{{ $item->id }}" type="button" class="jenis-button mr-1 mt-1 text-xs text-secondary bg-primary rounded-md p-2 hover:bg-primary_hover active:bg-secondary active:text-primary">
                                    {{ $item->raw_jeniskopi->nama }}
                                </button>
                            @else
                                <button type="" class="mr-1 mt-1 text-xs text-gray-400 bg-gray-100 rounded-md p-2" disabled>
                                    {{ $item->raw_jeniskopi->nama }}
                                </button>
                            @endif
                            
                        @endforeach
                    </div>
                    <p id="jenis-error" class="text-red-500 text-sm hidden">Silakan pilih jenis kopi</p>
                @endif
                
                <p class="font-semibold pt-4">Ingredients</p>
                <p class="text-sm">
                    @php
                        $ingredientNames = $data_ingredient->map(function ($data) {
                            return $data->raw_ingredient->nama;
                        })->toArray();
                        $lastIngredient = array_pop($ingredientNames); // Ambil elemen terakhir
                    @endphp

                    @if (count($ingredientNames) > 0)
                        {{ implode(', ', $ingredientNames) }}, dan {{ $lastIngredient }}
                    @else
                        {{ $lastIngredient }}
                    @endif
                </p>

                <p class="font-semibold pt-4">Deskripsi Produk</p>
                <p class="text-sm">
                    {{ $detail_kopi->deskripsi }}
                </p>

                <div class="my-1 bg-white text-white h-[80px]">
                    _
                </div>
            </div>
            
            {{-- Layout Web --}}
            @include('user.detail_kopi.web_detailkopi')
            
        </div>
    </div>
    
    {{-- footer --}}
    @include('user.detail_kopi.footer_detailkopi')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.jenis-button').click(function() {
                var jenisKopiId = $(this).data('id');
                $('#jeniskopi').val(jenisKopiId);
                $('#jeniskopi-cart').val(jenisKopiId);
                $('.jenis-button').removeClass('active border border-secondary font-semibold'); // Remove the active class from all buttons
                $(this).addClass('active border border-secondary font-semibold'); // Add the active class to the clicked button
                $('#jenis-error').addClass('hidden');
            });

            @if($data_jeniskopi->isNotEmpty())
                $('#order-form, #cart-form, #add-to-cart-form').submit(function(e) {
                    if (!$('#jeniskopi').val() && !$('#jeniskopi-cart').val()) {
                        e.preventDefault();
                        $('#jenis-error').removeClass('hidden');
                    }
                });
            @endif
            
            var pricePerUnit = {{ $detail_kopi->diskon > 0 ? $detail_kopi->harga_diskon : $detail_kopi->harga }};
            // var pricePerUnit = {{ $detail_kopi->harga_diskon }};
            //console.log(pricePerUnit);

            function updateQuantities(qty) {
                $('#quantity').val(qty);
                $('#order-quantity').val(qty);
                $('#cart-quantity').val(qty);
                updateTotalPrice(qty);
            }
            
            function updateTotalPrice(qty) {
                var totalPrice = qty * pricePerUnit;
                $('#total-price').text(totalPrice);
                $('#order-total').val(totalPrice);
                $('#cart-total').val(totalPrice);
            }

            $('#increase-qty').click(function() {
                var qty = parseInt($('#quantity').val());
                if (qty < {{ $detail_kopi->stok }}) {
                    updateQuantities(qty + 1);
                }
            });

            $('#decrease-qty').click(function() {
                var qty = parseInt($('#quantity').val());
                if (qty > 1) {
                    updateQuantities(qty - 1);
                }
            });
        });
    </script>
@endsection