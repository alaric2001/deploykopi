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

        {{-- Chart kpi order, stok menu, order perhari dll --}}
        @include('admin.mainpage.chart_main')
        
@endsection