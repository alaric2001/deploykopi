@extends('layouts.user')
@section('judul', $detail_kopi->jenis_kopi)
@section('content')
    <div class="my-4 lg:flex justify-center h-screen">
        <div class="mx-6 flex flex-col">
            <img class="rounded-lg h-[300px] object-cover" src="{{ asset('images/' . $detail_kopi->foto) }}" alt="foto kopi">
            <p class="pt-2 text-md">{{ $detail_kopi->jenis_kopi }}</p>
            <div class="flex items-center justify-between">
                <p class="font-semibold text-xl">Rp. <span id="total-price">{{ $detail_kopi->harga }}</span></p>
                <div class="flex items-center ml-4">
                    <button id="decrease-qty" class="bg-primary text-secondary text-sm font-medium px-[9px] py-1 rounded-3xl">-</button>
                    <input type="text" id="quantity" name="quantity" value="1" class="font-medium w-12 h-8 text-center border-none" readonly>
                    <button id="increase-qty" class="bg-secondary text-primary text-sm font-medium px-[8px] py-1 rounded-3xl">+</button>
                </div>
            </div>
            
            {{-- <div class="flex text-xs items-center gap-1 mt-2">
                <p>Stock {{ $detail_kopi->stok }}</p>
            </div> --}}
            @if($data_rasa->isNotEmpty())
                <p class="font-semibold pt-4">Rasa</p>
                <div class="">
                    @foreach ($data_rasa as $item)
                        <button type="button" class="rasa-button mr-1 mt-1 text-xs text-secondary bg-primary rounded-md p-2 hover:bg-primary_hover active:bg-secondary active:text-primary" data-id="{{ $item->id }}">
                            {{ $item->nama_rasa }}
                        </button>
                    @endforeach
                </div>
                <p id="rasa-error" class="text-red-500 text-sm hidden">Silakan pilih rasa kopi</p>
            @endif
            
            <p class="font-semibold pt-4">Deskripsi Produk</p>
            <p class="text-sm">
                {{ $detail_kopi->deskripsi }}
            </p>
        </div>
    </div>

    <footer class="fixed w-full bg-[#FFE5B6] text-black text-center py-3 bottom-0">
        <div class="flex justify-center gap-2">
            @if($tidakada_bukti_payment)
                <div class="w-[40%]">
                    <form id="order-form" action="/addOrder_deletedItem" method="post">
                        @csrf
                        <input type="hidden" name="rasakopi" id="rasakopi" value="">
                        <input type="hidden" name="quantity" id="order-quantity" value="1">
                        <input type="hidden" name="total" id="order-total" value="{{ $detail_kopi->harga }}">
                        <input type="hidden" name="kopi_id" value="{{ $detail_kopi->id }}">
                        <button type="submit" class="w-full rounded-md py-3 bg-[#3d372b] border border-[#3d372b] text-[#FFE5B6] hover:bg-[#25211a] text-sm">
                            Order
                        </button>
                    </form>
                </div>
            @else
                <div class="w-[40%]">
                    <form id="add-to-cart-form" action="/add_order" method="post">
                        @csrf
                        <input type="hidden" name="rasakopi" id="rasakopi" value="">
                        <input type="hidden" name="quantity" id="order-quantity" value="1">
                        <input type="hidden" name="total" id="order-total" value="{{ $detail_kopi->harga }}">
                        <input type="hidden" name="kopi_id" value="{{ $detail_kopi->id }}">
                        <button type="submit" class="w-full rounded-md py-3 bg-[#3d372b] border border-[#3d372b] text-[#FFE5B6] hover:bg-[#25211a] text-sm">
                            Order
                        </button>
                    </form>
                </div>
            @endif
            
            <div class="w-[40%]">
                <form id="cart-form" action="/add_cart" method="post">
                    @csrf
                    <input type="hidden" name="rasakopi" id="rasakopi-cart" value="">
                    <input type="hidden" name="quantity" id="cart-quantity" value="1">
                    <input type="hidden" name="total" id="cart-total" value="{{ $detail_kopi->harga }}">
                    <input type="hidden" name="kopi_id" value="{{ $detail_kopi->id }}">
                    <button type="submit" class="w-full rounded-md py-3 border border-black text-black hover:bg-[#dcc69e] text-sm">
                        Add to Cart
                    </button>
                </form>
            </div>
        </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.rasa-button').click(function() {
                var rasaId = $(this).data('id');
                $('#rasakopi').val(rasaId);
                $('#rasakopi-cart').val(rasaId);
                $('.rasa-button').removeClass('active border border-secondary font-semibold'); // Remove the active class from all buttons
                $(this).addClass('active border border-secondary font-semibold'); // Add the active class to the clicked button
                $('#rasa-error').addClass('hidden');
            });

            @if($data_rasa->isNotEmpty())
                $('#order-form, #cart-form').submit(function(e) {
                    if (!$('#rasakopi').val() && !$('#rasakopi-cart').val()) {
                        e.preventDefault();
                        $('#rasa-error').removeClass('hidden');
                    }
                });
            @endif


            var pricePerUnit = {{ $detail_kopi->harga }};
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
                updateQuantities(qty + 1);
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