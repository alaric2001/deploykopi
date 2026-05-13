<footer class="fixed w-full bg-[#FFE5B6] text-black text-center py-3 bottom-0 sm:hidden">
    <div class="flex justify-center gap-2 sm:hidden">
        @if($tidakada_bukti_payment)
            <div class="w-[40%]">
                <form id="order-form" action="/addOrder_deletedItem" method="post">
                    @csrf
                    <input type="hidden" name="jeniskopi" id="jeniskopi" value="">
                    <input type="hidden" name="quantity" id="order-quantity" value="1">
                    @if ($detail_kopi->diskon > 0)
                        <input type="hidden" name="total" id="order-total" value="{{ $detail_kopi->harga_diskon }}">
                    @else
                        <input type="hidden" name="total" id="order-total" value="{{ $detail_kopi->harga }}">
                    @endif
                    {{-- <input type="hidden" name="total" id="order-total" value=""> --}}
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
                    <input type="hidden" name="jeniskopi" id="jeniskopi" value="">
                    <input type="hidden" name="quantity" id="order-quantity" value="1">
                    @if ($detail_kopi->diskon > 0)
                        <input type="hidden" name="total" id="order-total" value="{{ $detail_kopi->harga_diskon }}">
                    @else
                        <input type="hidden" name="total" id="order-total" value="{{ $detail_kopi->harga }}">
                    @endif
                    {{-- <input type="hidden" name="total" id="order-total" value=""> --}}
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
                <input type="hidden" name="jeniskopi" id="jeniskopi-cart" value="">
                <input type="hidden" name="quantity" id="cart-quantity" value="1">
                @if ($detail_kopi->diskon > 0)
                    <input type="hidden" name="total" id="cart-total" value="{{ $detail_kopi->harga_diskon }}">
                @else
                    <input type="hidden" name="total" id="cart-total" value="{{ $detail_kopi->harga }}">
                @endif
                {{-- <input type="hidden" name="total" id="cart-total" value=""> --}}
                <input type="hidden" name="kopi_id" value="{{ $detail_kopi->id }}">
                <button type="submit" class="w-full rounded-md py-3 border border-black text-black hover:bg-[#dcc69e] text-sm">
                    Add to Cart
                </button>
            </form>
        </div>
    </div>
</footer>