@extends('layouts/admin')

@section('admin-content')
<div class="admin-container">
    <p class="text-2xl font-semibold">Transaksi</p>
    <div class="">
        <table id="order-table" class="w-full text-secondary font-sans">
            <thead class="">
                <tr class="bg-primary">
                    <th>No</th>
                    <th>Nama Pemesan</th>
                    <th>Total Tagihan</th>
                    {{-- <th>Dine In</th>
                    <th>No. Meja</th> --}}
                    <th>Status Order</th>
                    <th class="w-[140px]">Bukti Bayar</th>
                    <th>Tanggal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="bg-white">

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
                url: '/data-order-admin',
                method: 'GET',
                success: function(response) {
                    var data = response.transaksi_data;
                    // console.log(data)
                    var tableRows = '';
                    $.each(data, function(index, item) {
                        tableRows += '<tr>';
                        tableRows += '<td class="text-center">' + (index + 1) + '</td>';
                        tableRows += '<td>' + item.name + '</td>';
                        tableRows += '<td> Rp. ' +(item.total_price ? parseFloat(item.total_price).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') : '0')+ '</td>';
                        // tableRows += '<td>' + (item.dine_in == 'no' ? 'Takeaway': item.dine_in ? item.dine_in : '-') + '</td>';
                        // tableRows += '<td>' + (item.no_meja ? item.no_meja : '-') + '</td>';
                        tableRows += '<td>' + (item.order_telah_diantar == 'Belum diantar' ? '<p class="text-red-600 font-semibold">'+ item.order_telah_diantar +'</p>':
                                    '<p class="text-lime-600 font-semibold">' + item.order_telah_diantar + '</p>') + '</td>';
                        tableRows += '<td>' + (item.bukti_payment ? '<img class="" src="/images/bukti_bayar/' + item.bukti_payment + '" alt="gambar kopi">' : 
                                        '<p class="text-red-600 font-semibold">Belum Bayar</p>') + '</td>';
                        tableRows += '<td>' + new Date(item.created_at).toLocaleDateString() + '</td>'; // Mengubah tanggal menjadi hanya tanggal
                        tableRows += '<td class="w-[211px]">' + generateActionButtons(item) + '</td>'; // Menggunakan fungsi generateActionButtons()
                        
                        tableRows += '</tr>';
                    });
                    $('#order-table tbody').html(tableRows);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        // Initial data fetch
        loadData();

        // Auto reload data 
        setInterval(loadData, 10000);

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