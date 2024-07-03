@extends('layouts/admin')

@section('admin-content')
<div class="flex flex-col gap-4 mt-2">
    <p class="text-xl font-bold">Customer Order</p>
    <div class="flex justify-center">
        <table class="text-secondary w-4/5 font-sans">
            <thead class="">
                <tr class="bg-primary">
                    <th>No</th>
                    <th>Nama Pemesan</th>
                    <th>Total Tagihan</th>
                    <th>Dine In</th>
                    <th>No. Meja</th>
                    <th>Status Order</th>
                    <th>Bukti Bayar</th>
                    <th>Acton</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi_data as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->total_price }}</td>
                    <td>{{ $item->dine_in}}</td>
                    <td>{{ $item->no_meja }}</td>
                    <td>
                        @if ($item->order_telah_diantar == 'Belum diantar')
                            <p class="text-red-600 font-semibold">{{ $item->order_telah_diantar }}</p>
                        @else
                            <p class="text-lime-600 font-semibold">{{ $item->order_telah_diantar }}</p>
                        @endif
                        {{-- {{ $item->order_telah_diantar }} --}}
                    </td>
                    <td>
                        @if($item->bukti_payment)
                            <img class="w-20" src="{{ asset('images/bukti_bayar/'. $item->bukti_payment) }}" alt="gambar kopi">
                        @else
                            <p class="text-red-600 font-semibold">Belum Bayar</p>
                        @endif
                    </td>
                    <td class="w-[211px]">
                        <div class="flex gap-2">
                            @if ($item->bukti_payment)
                                <a class="p-2 bg-primary rounded-md text-sm text-secondary" href="/order-detail/{{ $item->id }}">
                                    Detail Order
                                </a>
                                @if ($item->order_telah_diantar == 'belum diantar')
                                    <form action="/delivered/{{ $item->id }}" method="POST">
                                        @csrf
                                        <button class=" text-sm rounded-md p-2 bg-secondary border border-secondary text-primary hover:bg-[#25211a]" type="submit" onclick="return confirm('Pesanan sudah lengkap?')">
                                            Delivered ?
                                        </button>
                                    </form>    
                                @else
                                    
                                @endif
                            @else
                                <p>-</p>
                            @endif
                        </div>
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<script>
    $(document).ready(function(){
        loadData();

        // Mengubah fungsi loadData() di dalam $(document).ready()
        function loadData() {
            $.ajax({
                url: '/order-list',
                method: 'GET',
                success: function(response) {
                    var data = response.transaksi_data;
                    var tableRows = '';
                    $.each(data, function(index, item) {
                        tableRows += '<tr>';
                        tableRows += '<td>' + (index + 1) + '</td>';
                        tableRows += '<td>' + item.nama_pemesan + '</td>';
                        tableRows += '<td>' + item.total_tagihan + '</td>';
                        tableRows += '<td>' + (item.dine_in ? 'Yes' : 'No') + '</td>';
                        tableRows += '<td>' + item.no_meja + '</td>';
                        tableRows += '<td>' + item.status_order + '</td>';
                        tableRows += '<td>' + (item.bukti_bayar ? '<a href="' + item.bukti_bayar + '">View</a>' : '-') + '</td>';
                        tableRows += '<td>' + generateActionButtons(item) + '</td>'; // Menggunakan fungsi generateActionButtons()
                        tableRows += '</tr>';
                    });
                    $('#order-table tbody').html(tableRows);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        // Menambahkan fungsi generateActionButtons() di dalam $(document).ready()
        function generateActionButtons(item) {
            var actionButtons = '<div class="flex gap-2">';
            if (item.bukti_payment) {
                actionButtons += '<a class="p-2 bg-primary rounded-md text-sm text-secondary" href="/order-detail/' + item.id + '">Detail Order</a>';
                if (item.order_telah_diantar == 'Belum diantar') {
                    actionButtons += '<form action="/delivered/' + item.id + '" method="POST">';
                    actionButtons += '@csrf';
                    actionButtons += '<button class=" text-sm rounded-md p-2 bg-secondary border border-secondary text-primary hover:bg-[#25211a]" type="submit" onclick="return confirm(\'Pesanan sudah lengkap?\')">Delivered ?</button>';
                    actionButtons += '</form>';
                }
            } else {
                actionButtons += '<p>-</p>';
            }
            actionButtons += '</div>';
            return actionButtons;
        }

    });
</script>

{{-- <script> p
    setTimeout(function() {
        window.location.reload();
    }, 10000); // 10 detik
</script> --}}
@endsection