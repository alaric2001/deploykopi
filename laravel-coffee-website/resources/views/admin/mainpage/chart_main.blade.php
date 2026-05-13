<div class="flex flex-row gap-2 justify-between">
    <div class="mt-8 w-[360px] h-[420px] bg-white rounded-md p-2">
        <p class="font-semibold">Kopi Orders</p>
        <canvas id="kopiOrdersChart" class=""></canvas>
    </div>

    <!-- Bar Chart for Kopi Stock -->
    <div class="flex flex-col mt-8 bg-white w-[780px] h-[420px] rounded-md p-2 2xl:w-[60%]">
        <div class="flex justify-center">
            <p class="font-semibold">Stok Menu Kopi</p>
        </div>
        <div class="flex justify-center h-[380px]">
            <canvas id="kopiStockChart"></canvas>
        </div>
    </div>
</div>

<!-- Bar Chart Stok Jenis kopi dan Ingredients -->
<div class="flex flex-row gap-2 justify-between">
    <div class="bg-white rounded-md p-2 w-1/2">
        <p class="font-semibold">Stok Jenis Kopi</p>
        <div class="">
            <canvas id="stokjeniskopi"></canvas>
        </div>
        
    </div>
    
    <div class="bg-white rounded-md p-2 w-1/2">
        <div class="flex justify-center">
            <p class="font-semibold">Stok Ingredients</p>
        </div>
        <div class="flex justify-center h-[380px]">
            <canvas id="stokingredient"></canvas>
        </div>
    </div>
</div>

{{-- Line chart transaksi bulanan --}}
<div class="mt-8 bg-white h-[420px] rounded-md p-2 pb-16">
    {{-- <p class="font-semibold">Total Order per Hari</p>
    <canvas id="ordersPerDayChart"></canvas> --}}
    <div class="flex justify-between items-center mb-4">
        <p class="font-semibold">Total Order per Hari</p>
        <div class="flex gap-2">
            <select id="bulan" class="border border-gray-300 rounded-md p-2">
                @foreach ($months as $key => $month)
                    <option value="{{ $key }}" {{ $bulan == $key ? 'selected' : '' }}>{{ $month }}</option>
                @endforeach
            </select>
            <select id="tahun" class="border border-gray-300 rounded-md p-2 w-[80px]">
                @foreach ($years as $year)
                    <option value="{{ $year }}" {{ $tahun == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <canvas id="ordersPerDayChart"></canvas>
</div>



</div> 



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    function getRandomColors(count) {
        let colors = [];
        for (let i = 0; i < count; i++) {
            colors.push(getRandomColor());
        }
        return colors;
    }

    const kopiLabels = {!! json_encode($kopiLabels) !!};
    const kopiQuantities = {!! json_encode($kopiQuantities) !!};
    const formattedData = {!! json_encode($formattedData) !!};
    const kopiNames = {!! json_encode($kopiNames) !!};
    const kopiStockLabels = {!! json_encode($kopiStockLabels) !!};
    const kopiStockQuantities = {!! json_encode($kopiStockQuantities) !!};

    const randomColors = getRandomColors(kopiLabels.length);

    // PIE Chart untuk mengetahui banyak pesanan menu kopi
    const ctx = document.getElementById('kopiOrdersChart').getContext('2d');
    const pieData = {
        labels: kopiLabels,
        datasets: [{
            data: kopiQuantities,
            backgroundColor: randomColors,
            borderColor: randomColors,
            borderWidth: 1
        }]
    };
    const pieConfig = {
        type: 'pie',
        data: pieData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            }
        },
    };
    new Chart(ctx, pieConfig);


    // Bar Chart for Kopi Stock
    const ctxBar = document.getElementById('kopiStockChart').getContext('2d');
    const barData = {
        labels: kopiStockLabels,
        datasets: [{
            label: 'Stok Menu Kopi',
            data: kopiStockQuantities,
            backgroundColor: '#e6aa3a', 
            borderWidth: 1
        }]
    };
    const barConfig = {
        type: 'bar',
        data: barData,
        options: {
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    };
    new Chart(ctxBar, barConfig);


    // Bar Chart Untuk Stok Jenis Kopi
    const chart_stok_jeniskopi = document.getElementById('stokjeniskopi').getContext('2d');
    const data_stok_jeniskopi = {
        labels: {!! json_encode($labelstokjeniskopi) !!},
        datasets: [{
            label: 'Stok Jenis Kopi',
            data: {!! json_encode($stok_jenikkopi) !!},
            backgroundColor: '#81B622', 
            borderWidth: 1
        }]
    };
    const bar_Config = {
        type: 'bar',
        data: data_stok_jeniskopi,
        options: {
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    };
    new Chart(chart_stok_jeniskopi, bar_Config);

    // Bar Chart Untuk Stok Ingredient
    const chart_stok_ingredient = document.getElementById('stokingredient').getContext('2d');
    const data_stok_ingredient = {
        labels: {!! json_encode($labelstokingredient) !!},
        datasets: [{
            label: 'Stok Ingrdient Kopi',
            data: {!! json_encode($stok_ingredient) !!},
            backgroundColor: '#21B6A8', 
            borderWidth: 1
        }]
    };
    const barConfig_ingredient = {
        type: 'bar',
        data: data_stok_ingredient,
        options: {
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    };
    new Chart(chart_stok_ingredient, barConfig_ingredient);


    // Line Chart untuk Pendapatan dari Order per Hari
    const lineLabels = Object.values(formattedData)[0].dates; // Assuming all kopi have the same dates
    const lineDatasets = Object.keys(formattedData).map((kopiId, index) => ({
        label: kopiNames[kopiId],
        data: formattedData[kopiId].quantities,
        borderColor: randomColors[index],
        backgroundColor: randomColors[index],
        fill: false,
        tension: 0.1
    }));

    const ctxLine = document.getElementById('ordersPerDayChart').getContext('2d');
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

    // Event listener untuk dropdown bulan dan tahun
    document.getElementById('bulan').addEventListener('change', function() {
        const selectedMonth = this.value;
        const selectedYear = document.getElementById('tahun').value;
        window.location.href = `?bulan=${selectedMonth}&tahun=${selectedYear}`;
    });

    document.getElementById('tahun').addEventListener('change', function() {
        const selectedYear = this.value;
        const selectedMonth = document.getElementById('bulan').value;
        window.location.href = `?bulan=${selectedMonth}&tahun=${selectedYear}`;
    });
    // //PIE Chart untuk mengetahui banyak pesanan menu kopi
    // const ctx = document.getElementById('kopiOrdersChart').getContext('2d');
    // const data = {
    //     labels: {!! json_encode($kopiLabels) !!},
    //     datasets: [{
    //         data: {!! json_encode($kopiQuantities) !!},
    //         backgroundColor: [
    //             '#FF4C33', 
    //             '#36A2EB', // Biru
    //             '#FFCE56', // Kuning
    //             '#4BC0C0', // Hijau kebiruan
    //             '#9966FF', // Ungu
    //             '#FF9F40',  // Oranye
    //             '#20B2AA',
    //             '#FFD700',
    //             '#3CB371',
    //         ],
    //         borderColor: [
    //             '#FF6384', // Merah muda
    //             '#36A2EB', // Biru
    //             '#FFCE56', // Kuning
    //             '#4BC0C0', // Hijau kebiruan
    //             '#9966FF', // Ungu
    //             '#FF9F40',  // Oranye
    //             '#20B2AA',
    //             '#FFD700',
    //             '#3CB371',
    //         ],
    //         borderWidth: 1
    //     }]
    // };
    // const config = {
    //     type: 'pie',
    //     data: data,
    //     options: {
    //         responsive: true,
    //         plugins: {
    //             legend: {
    //                 position: 'top',
    //             },
    //         }
    //     },
    // };
    // new Chart(ctx, config);

    // // Grafik garis untuk Pendapatan dari Order per Hari // 
    // const formattedData = {!! json_encode($formattedData) !!};
    // const kopiNames = {!! json_encode($kopiNames) !!};
    // const lineLabels = Object.values(formattedData)[0].dates; // Assuming all kopi have the same dates

    // const lineDatasets = Object.keys(formattedData).map(kopiId => ({
    //     label: kopiNames[kopiId],
    //     data: formattedData[kopiId].quantities,
    //     borderColor: getRandomColor(),
    //     fill: false,
    //     tension: 0.1
    // }));

    // const ctxLine = document.getElementById('ordersPerDayChart').getContext('2d'); // Mendefinisikan ctxLine

    // const lineData = {
    //     labels: lineLabels,
    //     datasets: lineDatasets
    // };

    // const lineConfig = {
    //     type: 'line',
    //     data: lineData,
    //     options: {
    //         responsive: true,
    //         maintainAspectRatio: false,
    //         plugins: {
    //             legend: {
    //                 position: 'top',
    //             },
    //         },
    //         scales: {
    //             x: {
    //                 title: {
    //                     display: true,
    //                     text: 'Date'
    //                 }
    //             },
    //             y: {
    //                 title: {
    //                     display: true,
    //                     text: 'Total Orders'
    //                 }
    //             }
    //         }
    //     },
    // };
    // new Chart(ctxLine, lineConfig);

    // // Bar Chart for Kopi Stock
    // const ctxBar = document.getElementById('kopiStockChart').getContext('2d');
    // const barData = {
    //     labels: {!! json_encode($kopiStockLabels) !!},
    //     datasets: [{
    //         label: 'Stok Menu Kopi',
    //         data: {!! json_encode($kopiStockQuantities) !!},
    //         backgroundColor: '#e6aa3a', 
    //         // borderColor: '#36A2EB',
    //         borderWidth: 1
    //     }]
    // };
    // const barConfig = {
    //     type: 'bar',
    //     data: barData,
    //     options: {
    //         responsive: true,
    //         scales: {
    //             x: {
    //                 beginAtZero: true
    //             },
    //             y: {
    //                 beginAtZero: true
    //             }
    //         }
    //     }
    // };
    // new Chart(ctxBar, barConfig);

    // function getRandomColor() {
    //     const letters = '0123456789ABCDEF';
    //     let color = '#';
    //     for (let i = 0; i < 6; i++) {
    //         color += letters[Math.floor(Math.random() * 16)];
    //     }
    //     return color;
    // }

    // // Event listener untuk dropdown bulan dan tahun
    // document.getElementById('bulan').addEventListener('change', function() {
    //     const selectedMonth = this.value;
    //     const selectedYear = document.getElementById('tahun').value;
    //     window.location.href = `?bulan=${selectedMonth}&tahun=${selectedYear}`;
    // });

    // document.getElementById('tahun').addEventListener('change', function() {
    //     const selectedYear = this.value;
    //     const selectedMonth = document.getElementById('bulan').value;
    //     window.location.href = `?bulan=${selectedMonth}&tahun=${selectedYear}`;
    // });
});
</script>