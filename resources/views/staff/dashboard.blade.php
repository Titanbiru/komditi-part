@extends('layouts.staff')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        

        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 text-center">
            <h3 class="text-lg font-semibold text-[#202020] mb-3">Today Transaction</h3>
            <p class="text-2xl font-bold text-[#CD2828]">
                {{$totalTransactions}}
            </p>
        </div>
        
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 text-center">
            <h3 class="text-lg font-semibold text-[#202020] mb-3">Today Revenue</h3>
            <p class="text-2xl font-bold text-[#CD2828]">
                Rp {{number_format($totalSales,0,',','.')}}
            </p>
        </div>
        
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 text-center">
            <h3 class="text-lg font-semibold text-[#202020] mb-3">Active Order</h3>
            <p class="text-[10px] text-gray-500 italic mb-2">*pending, process, shipped</p>
            <p class="text-2xl font-bold text-[#CD2828]">
                {{ $activeOrders }} <span class="text-black text-2xl font-bold">orders</span>
            </p>
        </div>
        
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 text-center">
            <h3 class="text-lg font-semibold text-[#202020] mb-3">Low Stock Count</h3>
            <p class="text-2xl font-bold text-[#CD2828]">
                {{ $lowStock }} <span class="text-black text-2xl font-bold">product</span>
            </p>
        </div>
    </div>

    <hr class="border-[1px] border-[#CD2828] mb-8">

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-[#202020]">Latest Backup</h2>
    </div>
    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <p class="text-sm text-gray-600">status backup</p>
            <div>
                <p class="font-medium text-[#202020]">
                    26/1/2026 
                    <span class="inline-block px-3 py-1 bg-[#1BCFD5] text-white text-xs font-semibold rounded-full ml-2">
                        done
                    </span>
                </p>
            </div>
        </div>
    </div>
@endsection