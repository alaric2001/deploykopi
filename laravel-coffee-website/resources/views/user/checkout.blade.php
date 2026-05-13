@extends('layouts.user')
@section('judul', 'Checkout')
@section('content')
<div class="flex justify-center">
    <div class="pt-[80px] mb-4 mx-6 flex flex-col w-[90%] sm:w-[800px]">
        <div class="mb-4">
            <p class="text-xl font-semibold">Checkout</p>
            <div class="flex flex-row justify-between">
                <p class="text-xs">No. Transaksi</p>
                <p class="text-xs">{{ $transaksi->id }}</p>
            </div>
            
        </div>
        <form action="/checkout_order" method="post" enctype="multipart/form-data">
            @csrf
            <div class="bg-white border opacity-[0px] rounded-[10px] border-solid border-[#D9D9D9] mb-4 p-3 flex flex-col gap-2">
                <p class="font-semibold flex gap-1">
                    <i class="material-icons text-secondary">person</i> {{ Auth::user()->name_user }}
                </p>
                <div class="flex flex-col gap-1 mb-4">
                    <select class="p-1 text-xs rounded-md mb-1" name="order" id="orderSelect" onchange="toggleTableInput()" required>
                        <option value="" disabled selected hidden>Delivery/Takeaway</option>
                        <option value="yes">Delivery</option>
                        <option value="no">Takeaway</option>
                    </select>
                    <div class="hidden" id="tableNumberInput">
                        {{-- <label class="text-xs" for="tableNumberInput">Pilih Alamat Pengiriman</label> --}}
                        <p class="text-xs">Pilih Alamat Pengiriman</p>
                        <div class="flex flex-col gap-1" id="alamatList">
                            @foreach ($alamat as $data)
                            <div class="address-item active:bg-slate-300 cursor-pointer bg-white border opacity-[0px] rounded-[4px] border-solid border-[#D9D9D9] p-2 flex flex-col" data-id="{{ $data->id }}" data-ongkir="{{ $data->harga_ongkir }}">
                                    <p class="text-sm font-semibold">{{ $data->kel }}</p>
                                    <p class="text-sm">{{ $data->kec }} {{ $data->kodepos }}</p>
                                    <p class="text-xs pt-2">{{ $data->detail}}</p>
                                    <p class="text-xs pt-2 font-semibold">
                                        @if ($data->harga_ongkir > 0)
                                            Ongkir: Rp {{ $data->harga_ongkir }}
                                        @else
                                            Free Ongkir
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        </div>
                        
                        <input value="" class="p-1 text-xs rounded-md" type="hidden" name="alamat" placeholder="" id="alamatInput">
                    </div>
                </div>
            </div>
        
            
            <div>
                <p class="font-semibold text-sm flex gap-1">
                    <i class="material-icons text-secondary">local_cafe</i> Pesanan
                </p>
                @foreach ($cart_data as $cart)
                    <div class="bg-white border opacity-[0px] rounded-[10px] border-solid border-[#D9D9D9] mb-4 p-3 flex flex-col gap-1">
                        <div class="flex justify-end mr-2">
                            <a class="font-semibold text-[12px] text-red-500" href="/delete_cart/{{ $cart->id }}" onclick="return confirm('Anda yakin akan menghapus pesanan?')">
                            Hapus
                            </a>
                        </div>
                        
                        <div class="flex flex-row mx-2 mb-2 gap-4 items-start">
                            <img class="w-[81px] h-[84px] gap-0 opacity-[0px] rounded-xl object-cover" src="{{ asset('images/' . $cart->kopi->foto) }}" alt="foto pesanan">
                            <div class="flex flex-col">
                                <p class="text-sm">{{ $cart->kopi->jenis_kopi }}</p>
                                @if ($cart->jeniskopi && $cart->jeniskopi->nama_jenis)
                                    <p class="mr-1 text-xs text-secondary">Jenis Kopi - {{ $cart->jeniskopi->nama_jenis }}</p>
                                @endif
                                <p class="font-bold text-[12px]">
                                    @if ($cart->kopi->diskon > 0)
                                        <span>{{ $cart->quantity }} x </span> Rp. {{ $cart->kopi->harga_diskon }}
                                    @else
                                        <span>{{ $cart->quantity }} x </span> Rp. {{ $cart->kopi->harga }}
                                    @endif
                                    
                                </p>
                                {{-- <p class="font-bold text-[12px]"><span>{{ $cart->quantity }} x </span> Rp. {{ $cart->kopi->harga }}</p> --}}
                                {{-- <div class="flex items-center">
                                    <button id="decrease-qty" class="bg-primary text-secondary text-sm font-medium px-[9px] py-1 rounded-3xl">-</button>
                                    <input type="text" id="quantity" name="quantity" value="{{ $cart->quantity }}" class="font-medium w-12 h-8 text-center border-none" readonly>
                                    <button id="increase-qty" class="bg-secondary text-primary text-sm font-medium px-[8px] py-1 rounded-3xl">+</button>
                                </div> --}}
                                {{-- <input class="rounded-[4px] w-[60px] h-[30px] border border-solid border-[#D9D9D9]" type="number" placeholder="{{ $cart->quantity }}" value=""> --}}
                            </div>
                            
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="bg-white text-xs border opacity-[0px] rounded-[10px] border-solid border-[#D9D9D9] mb-4 p-3 flex flex-row justify-between">
                <p class="font-semibold">Total Harga</p>
                <p id="totalAmountDisplay">Rp. {{ $total_amount }}</p>
                <input type="hidden" name="total_amount" id="totalAmountInput" value="{{ $total_amount }}">
            </div>
            
            {{-- Pilih metode pembayaran --}}
            <div class=" text-xs mb-4 flex flex-col gap-1">
                <p class="font-semibold">Pilih Metode Pembayaran</p>
                <div class="flex flex-row gap-3">
                    @foreach ($unique_payment_methods as $item)
                        <div class="font-medium rounded-md p-2 bg-[#FFE5B6] border border-[#dcc69e] text-[#3d372b] hover:bg-[#dcc69e] text-xs filter-btn" data-jenis="{{ $item->jenis }}">{{ $item->jenis }}</div>
                    @endforeach
                </div>
            </div>
    
            <div id="payment-methods-container" class="hidden">
                @foreach ($payment_method as $data)
                    <div class="payment-method" data-jenis="{{ $data->jenis }}">
                        @if ($data->jenis=='Qris')
                            <div class="bg-white text-xs border rounded-[10px] border-solid border-[#D9D9D9] mb-4 p-3">
                                <div>
                                    <p class="font-semibold">QRIS</p>
                                    <p class="">{{ $data->atas_nama }}</p>
                                </div>
                                <img src="{{ asset('images/'.$data->foto) }}" alt="qris">
                            </div>
                        @else
                            <div class="bg-white text-xs border rounded-[10px] border-solid border-[#D9D9D9] mb-4 p-3 flex flex-row justify-between items-center">
                                <div>
                                    <p class="font-semibold">{{ $data->nama }}</p>
                                    <p class="">{{ $data->atas_nama }}</p>
                                </div>
                                <p>{{ $data->nomor }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            
            {{-- kirim bukti pembayaran --}}
            <label for="fileInput" class="text-xs">
                <p class="font-semibold">Bukti Pembayaran</p>
                <input id="fileInput" type="file" name='bukti_bayar' class="bg-white p-1 text-xs rounded-md border border-[#D9D9D9]">
            </label>
            @if ($errors->has('bukti_bayar'))
                <div class="text-red-600 text-xs my-1">
                    {{ $errors->first('bukti_bayar') }} 
                    {{-- Bukti bayar harus jpg/jpeg/png --}}
                </div>
            @endif
    
            <button class="flex justify-center rounded-md p-2 bg-[#3d372b] border border-[#3d372b] text-[#FFE5B6] hover:bg-[#25211a] text-sm mt-4" type="submit">
                Kirim Bukti Pembayaran
            </button>
    
            {{-- <div class=" text-xs border opacity-[0px] rounded-[10px] border-solid border-[#D9D9D9] mb-4 p-3 flex flex-row justify-between items-center">
                <div>
                    <p class="font-semibold">Bank BCA</p>
                    <p class="">Farhan Hibatullah</p>
                </div>
                <p>5681404032</p>
            </div> --}}
    
            {{-- <div class=" text-xs border opacity-[0px] rounded-[10px] border-solid border-[#D9D9D9] mb-4 p-3 flex flex-row justify-between items-center">
                <div>
                    <p class="font-semibold">GoPay</p>
                    <p class="">Farhan Hibatullah</p>
                </div>
                <p>081384487598</p>
            </div> --}}
    
            {{-- <div class=" text-xs border opacity-[0px] rounded-[10px] border-solid border-[#D9D9D9] mb-4 p-3 ">
                <div>
                    <p class="font-semibold">QRIS</p>
                    <p class="">Farhan Hibatullah</p>
                </div>
                <img src="{{ asset('images/qris-try.png') }}" alt="qris">
            </div> --}}
        </form>
        
    </div>
</div>



{{-- Payment Method --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', function() {
                const jenis = this.getAttribute('data-jenis');
                document.querySelectorAll('.payment-method').forEach(method => {
                    if (method.getAttribute('data-jenis') === jenis) {
                        document.getElementById("payment-methods-container").classList.remove('hidden')
                        method.style.display = 'block';
                    } else {
                        method.style.display = 'none';
                    }
                });
            });
        });

        document.querySelectorAll('.address-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.address-item').forEach(el => el.classList.remove('bg-slate-300'));
                this.classList.add('bg-slate-300');

                const id = this.getAttribute('data-id');
                const ongkir = parseInt(this.getAttribute('data-ongkir'));

                document.getElementById('alamatInput').value = id;

                const totalAmount = parseInt({{ $total_amount }});
                const newTotalAmount = totalAmount + ongkir;
                document.getElementById('totalAmountDisplay').innerText = 'Rp. ' + newTotalAmount;
                document.getElementById('totalAmountInput').value = newTotalAmount;
            });
        });
    });
</script>

<script>
    function toggleTableInput() {
        var orderSelect = document.getElementById("orderSelect");
        var tableNumberInput = document.getElementById("tableNumberInput");
        
        // Jika Dine In dipilih, tampilkan input nomor meja; jika tidak, sembunyikan input nomor meja
        if (orderSelect.value === "yes") {
            tableNumberInput.classList.remove('hidden');
            tableNumberInput.classList.add('flex', 'flex-col', 'items-center', 'gap-2');
        } 
        else {
            tableNumberInput.classList.add('hidden');
            tableNumberInput.classList.remove('flex', 'flex-row', 'items-center', 'gap-2');
        }
    }
</script>



@endsection