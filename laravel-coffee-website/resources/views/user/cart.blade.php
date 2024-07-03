@extends('layouts.user')
@section('judul', 'Keranjang')
@section('content')
    {{-- @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif --}}
    <div class="flex flex-col items-center lg:flex lg:justify-center h-screen my-4">
        
        @if ($cart_data->count() > 0)
            @foreach ($cart_data as $cart)
                <div class="cart-item mb-4">
                    <div class="flex justify-end m-1 mr-2">
                        <a class="font-semibold text-[12px] text-red-500" href="/delete_cart/{{ $cart->id }}" onclick="return confirm('Anda yakin akan menghapus pesanan?')">
                        Hapus
                        </a>
                    </div>
                    
                    <div class="flex flex-row mx-4 mb-2 gap-4 items-start">
                        <img class="w-[81px] h-[84px] gap-0 opacity-[0px] rounded-xl object-cover" src="{{ asset('images/' . $cart->kopi->foto) }}" alt="foto pesanan">
                        <div class="flex flex-col">
                            <p class="text-sm">{{ $cart->kopi->jenis_kopi }}</p>
                            @if ($cart->rasakopi && $cart->rasakopi->nama_rasa)
                                <p class="rasa-button mr-1 text-xs text-secondary">Rasa - {{ $cart->rasakopi->nama_rasa }}</p>
                            @endif
                            {{-- <p class="font-bold text-[12px]">Rp. {{ $cart->jumlah }}</p> --}}
                            <p class="font-bold text-[12px]">Rp. <span id="total-price">{{ $cart->jumlah }}</span></p>
                            <div class="flex items-center">
                                <button id="decrease-qty" class="bg-primary text-secondary text-sm font-medium px-[9px] py-1 rounded-3xl">-</button>
                                <input type="text" id="quantity" name="quantity" value="{{ $cart->quantity }}" class="text-xs font-medium w-10 h-8 text-center border-none" readonly>
                                <button id="increase-qty" class="bg-secondary text-primary text-sm font-medium px-[8px] py-1 rounded-3xl">+</button>
                            </div>
                            {{-- <input class="rounded-[4px] w-[60px] h-[30px] border border-solid border-[#D9D9D9]" type="number" placeholder="{{ $cart->quantity }}" value=""> --}}
                        </div>
                        
                    </div>
                    
                    
                </div>
                
            @endforeach
            
                @if($tidakada_bukti_payment)
                    <a class="flex justify-center w-[40%] rounded-md py-3 bg-[#3d372b] border border-[#3d372b] text-[#FFE5B6] hover:bg-[#25211a] text-sm" href="/checkout">
                        Order
                    </a>
                @else
                    <div class="w-[40%]">
                        <form action="/cart_order" method="post">
                            @csrf
                            <input type="hidden" name="quantity" id="cart-quantity" value="1">
                            <button type="submit" class="w-full rounded-md py-3 bg-[#3d372b] border border-[#3d372b] text-[#FFE5B6] hover:bg-[#25211a] text-sm">
                                Order
                            </button>
                        </form>
                    </div>
                @endif
        @else
            <p>Wah, keranjang belanjaanmu kosong!</p>
        @endif
        
        
    </div>
    


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

            $('#order-form, #cart-form').submit(function(e) {
                if (!$('#rasakopi').val() && !$('#rasakopi-cart').val()) {
                    e.preventDefault();
                    $('#rasa-error').removeClass('hidden');
                }
            });


            var pricePerUnit = 0; // Inisialisasi harga per unit dengan nilai default

            @if(isset($cart))
                pricePerUnit = {{ $cart->kopi->harga }}; // Tetapkan harga per unit jika $cart didefinisikan
            @endif
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