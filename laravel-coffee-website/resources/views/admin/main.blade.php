@extends('layouts/admin')

@section('admin-content')
    <div class="admin-container">
        <p class="text-2xl font-semibold">Seteguk Kopi Main Dashboard</p>
        <div class="flex flex-row gap-2 justify-between">
            <div class="flex items-center gap-2 bg-white w-[360px] p-4 rounded-md">
                <div class="flex items-center p-4 rounded-full text-white bg-blue-400">
                    <i class="material-icons">attach_money</i>
                </div>
                <div class='flex flex-col'>
                    <p class="text-sm">Total Income</p>
                    <p class="font-semibold">Rp. {{ number_format($totalPrice, 2) }}</p>
                </div>
            </div>

            <a href="/order-list" class="flex items-center gap-2 bg-white w-[360px] p-4 rounded-md">
                <div class="flex items-center p-4 rounded-full text-white bg-orange-400">
                    <i class="material-icons">shopping_cart</i>
                </div>
                <div class='flex flex-col'>
                    <p class="text-sm">Total Orders</p>
                    <p class="font-semibold">{{ $totalTransaksi }}</p>
                </div>
            </a>

            <div class="flex items-center gap-2 bg-white w-[360px] p-4 rounded-md">
                <div class="flex items-center p-4 rounded-full text-white bg-green-400">
                    <i class="material-icons">group</i>
                </div>
                <div class='flex flex-col'>
                    <p class="text-sm">Registered Users</p>
                    <p class="font-semibold">{{ $totalUsers }}</p>
                </div>
            </div>

        </div>

        <div class="flex flex-row gap-2 justify-between">
            <div class="mt-8 w-[360px] h-[420px] bg-white rounded-md p-2">
                <p class="font-semibold">Kopi Orders</p>
                <canvas id="kopiOrdersChart" class=""></canvas>
            </div>
    
            <div class="mt-8 bg-white w-[750px] h-[420px] rounded-md p-2 pb-8">
                <p class="font-semibold">Total Order per Hari</p>
                <canvas id="ordersPerDayChart"></canvas>
            </div>
        </div>
        
        
    </div> 
    


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('kopiOrdersChart').getContext('2d');
            const data = {
                labels: {!! json_encode($kopiLabels) !!},
                datasets: [{
                    data: {!! json_encode($kopiQuantities) !!},
                    backgroundColor: [
                        '#FF4C33', 
                        '#36A2EB', // Biru
                        '#FFCE56', // Kuning
                        '#4BC0C0', // Hijau kebiruan
                        '#9966FF', // Ungu
                        '#FF9F40',  // Oranye
                        '#20B2AA',
                        '#FFD700',
                        '#3CB371',
                    ],
                    borderColor: [
                        '#FF6384', // Merah muda
                        '#36A2EB', // Biru
                        '#FFCE56', // Kuning
                        '#4BC0C0', // Hijau kebiruan
                        '#9966FF', // Ungu
                        '#FF9F40',  // Oranye
                        '#20B2AA',
                        '#FFD700',
                        '#3CB371',
                    ],
                    borderWidth: 1
                }]
            };
            const config = {
                type: 'pie',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                    }
                },
            };
            new Chart(ctx, config);

            // Prepare line chart data
            const formattedData = {!! json_encode($formattedData) !!};
            const kopiNames = {!! json_encode($kopiNames) !!};
            const lineLabels = Object.values(formattedData)[0].dates; // Assuming all kopi have the same dates

            const lineDatasets = Object.keys(formattedData).map(kopiId => ({
                label: kopiNames[kopiId],
                data: formattedData[kopiId].quantities,
                borderColor: getRandomColor(),
                fill: false,
                tension: 0.1
            }));

            // Grafik garis
            const ctxLine = document.getElementById('ordersPerDayChart').getContext('2d'); // Mendefinisikan ctxLine

            const lineData = {
                labels: lineLabels,
                datasets: lineDatasets
            };

            const lineConfig = {
                type: 'line',
                data: lineData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Total Orders'
                            }
                        }
                    }
                },
            };

            new Chart(ctxLine, lineConfig);

            function getRandomColor() {
                const letters = '0123456789ABCDEF';
                let color = '#';
                for (let i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }
        });
    </script>
@endsection