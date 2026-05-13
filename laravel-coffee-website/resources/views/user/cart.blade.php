@extends('layouts.user')
@section('judul', 'Keranjang')
@section('content')
    {{-- @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif --}}
    <div class="flex justify-center">
        <div class="pt-[80px] flex flex-col items-center h-screen sm:w-[800px]">
            @if ($cart_data->count() > 0)
                @foreach ($cart_data as $cart)
                    <div class="cart-item mb-4 bg-white sm:w-[80%]" data-cart-id="{{ $cart->id }}">
                        <div class="flex justify-end m-1 mr-2">
                            <a class="font-semibold text-[12px] text-red-500" href="/delete_cart/{{ $cart->id }}" onclick="return confirm('Anda yakin akan menghapus pesanan?')">
                            Hapus
                            </a>
                        </div>
                        
                        <div class="flex flex-row mx-4 mb-2 gap-4 items-start">
                            <img class="w-[81px] h-[84px] gap-0 opacity-[0px] rounded-xl object-cover" src="{{ asset('images/' . $cart->kopi->foto) }}" alt="foto pesanan">
                            <div class="flex flex-col">
                                <p class="text-sm">{{ $cart->kopi->jenis_kopi }}</p>
                                @if ($cart->jeniskopi && $cart->jeniskopi->nama_jenis)
                                    <p class="jenis-button mr-1 text-xs text-secondary">Jenis Kopi - {{ $cart->jeniskopi->nama_jenis }}</p>
                                @endif
                                {{-- <p class="font-bold text-[12px]">Rp. {{ $cart->jumlah }}</p> --}}
                                <p class="font-bold text-[12px]">Rp. <span class="total-price">{{ $cart->jumlah }}</span></p>
                                <div class="flex items-center">
                                    <button id="" class="decrease-qty bg-primary text-secondary text-sm font-medium px-[9px] py-1 rounded-3xl">-</button>
                                    <input type="" value="{{ $cart->quantity }}" class="quantity text-xs font-medium w-10 h-8 text-center border-none" readonly>
                                    <button id="" class="increase-qty bg-secondary text-primary text-sm font-medium px-[8px] py-1 rounded-3xl">+</button>
                                </div>
                                {{-- <input class="rounded-[4px] w-[60px] h-[30px] border border-solid border-[#D9D9D9]" type="number" placeholder="{{ $cart->quantity }}" value=""> --}}
                            </div>
                            
                        </div>
                        
                        
                    </div>
                    
                @endforeach
                
                    @if($tidakada_bukti_payment)
                        <a id="order-link" class="flex justify-center w-[40%] rounded-md py-3 bg-[#3d372b] border border-[#3d372b] text-[#FFE5B6] hover:bg-[#25211a] text-sm" href="#">
                            Order
                        </a>
                    @else
                        <div class="w-[40%]">
                            <form action="/cart_order" method="post">
                                @csrf
                                <input type="hidden" name="cart_items" id="cart-items" value="">
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
    </div>
    
    


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var pricePerUnit = 0; // Inisialisasi harga per unit dengan nilai default
    
            @if(isset($cart))
                pricePerUnit = {{ $cart->kopi->diskon > 0 ? $cart->kopi->harga_diskon : $cart->kopi->harga}}; // Tetapkan harga per unit jika $cart didefinisikan
            @endif
    
            function updateQuantities($item, qty) {
                $item.find('.quantity').val(qty);
                updateTotalPrice($item, qty);
            }
            
            function updateTotalPrice($item, qty) {
                var totalPrice = qty * pricePerUnit;
                $item.find('.total-price').text(totalPrice);
            }
    
            $('.increase-qty').click(function() {
                var $item = $(this).closest('.cart-item');
                var qty = parseInt($item.find('.quantity').val());
                updateQuantities($item, qty + 1);
            });
    
            $('.decrease-qty').click(function() {
                var $item = $(this).closest('.cart-item');
                var qty = parseInt($item.find('.quantity').val());
                if (qty > 1) {
                    updateQuantities($item, qty - 1);
                }
            });
    
            $('#order-link').click(function(e) {
                e.preventDefault();
                var cartItems = [];
                $('.cart-item').each(function() {
                    var id = $(this).data('cart-id');
                    var quantity = $(this).find('.quantity').val();
                    var total = $(this).find('.total-price').text();
                    cartItems.push({ id: id, quantity: quantity, total: total });
                });
                $.ajax({
                    url: '/cart_update_and_order',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        cart_items: JSON.stringify(cartItems)
                    },
                    success: function(response) {
                        window.location.href = '/checkout';
                    }
                });
            });
        });
    </script>
@endsection