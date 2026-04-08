@extends('layouts.staff')

@section('content')
    <div class="mb-10">
        <h1 class="text-3xl font-black text-[#202020] uppercase tracking-tighter">Staff Overview</h1>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Laporan Operasional Harian Komditi Part</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white rounded-2xl shadow-sm border-2 border-gray-100 p-6 hover:border-[#CD2828] transition-all duration-300">
            <h3 class="text-[10px] font-black uppercase text-gray-400 mb-4 tracking-widest">Today Orders</h3>
            <p class="text-2xl font-black text-[#202020]">{{ $totalTransactions }}</p>
            <p class="text-[9px] font-bold text-gray-400 uppercase mt-2 tracking-tight">Pesanan Masuk Hari Ini</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border-2 border-gray-100 p-6 hover:border-[#CD2828] transition-all duration-300">
            <h3 class="text-[10px] font-black uppercase text-gray-400 mb-4 tracking-widest">Today Revenue</h3>
            <p class="text-2xl font-black text-[#CD2828]">
                Rp {{ number_format($totalSales, 0, ',', '.') }}
            </p>
            <p class="text-[9px] font-bold text-green-500 uppercase mt-2 tracking-tight">Sudah Bayar (Verified)</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border-2 border-gray-100 p-6 hover:border-[#CD2828] transition-all duration-300">
            <h3 class="text-[10px] font-black uppercase text-gray-400 mb-4 tracking-widest">Active Processing</h3>
            <p class="text-2xl font-black text-[#202020]">{{ $activeOrders }}</p>
            <p class="text-[9px] font-bold text-gray-400 uppercase mt-2 tracking-tight">Perlu Diproses/Kirim</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border-2 border-gray-100 p-6 hover:border-[#CD2828] transition-all duration-300">
            <h3 class="text-[10px] font-black uppercase text-gray-400 mb-4 tracking-widest">Stock Critical</h3>
            <p class="text-2xl font-black text-orange-500">{{ $lowStock }}</p>
            <p class="text-[9px] font-bold text-red-500 uppercase mt-2 tracking-tight animate-pulse">Segera Restock</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div class="bg-white rounded-[2rem] border-2 border-gray-100 shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center bg-orange-50/50">
                <h3 class="text-[11px] font-black text-orange-600 uppercase tracking-[0.2em]">Perlu Restock</h3>
                <span class="text-[9px] font-black bg-orange-500 text-white px-3 py-1 rounded-full uppercase">Action Needed</span>
            </div>
            <div class="p-6 flex-grow">
                <div class="space-y-4">
                    @forelse($lowStockList as $low)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border-2 border-transparent hover:border-orange-200 transition-all">
                        <div class="min-w-0 flex-grow">
                            <p class="text-xs font-black text-gray-800 uppercase truncate">{{ $low->name }}</p>
                            <p class="text-[9px] font-black text-gray-400 mt-1 uppercase tracking-widest">Sisa Stok: <span class="text-orange-600 font-black">{{ $low->stock }} Unit</span></p>
                        </div>
                        {{-- TOMBOL UPDATE STOK UNTUK STAFF --}}
                        <a href="{{ route('staff.products.index') }}" class="ml-4 bg-black text-white text-[9px] font-black px-4 py-2 rounded-xl uppercase hover:bg-[#CD2828] transition-all">
                            Update
                        </a>
                    </div>
                    @empty
                    <div class="text-center py-10 text-[10px] font-black text-gray-400 uppercase">Semua barang aman.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border-2 border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-[11px] font-black text-[#202020] uppercase tracking-[0.2em]">Pesanan Perlu Diproses</h2>
                <a href="{{ route('staff.reports.transactions') }}" class="text-[9px] font-black text-gray-400 uppercase hover:text-black transition-all">Manajemen Order</a>
            </div>
            <div class="p-8">
                {{-- Di sini Mas bisa ambil data order terbaru yang statusnya pending/process --}}
                <div class="space-y-4">
                    {{-- Simulasi list pesanan --}}
                    @php
                        $pendingTasks = \App\Models\Order::whereIn('shipment_status', ['pending', 'processing'])->latest()->take(4)->get();
                    @endphp

                    @forelse($pendingTasks as $task)
                    <div class="flex items-center gap-4 p-4 border-2 border-gray-50 rounded-2xl hover:bg-gray-50 transition-all">
                        <div class="w-10 h-10 bg-black text-white rounded-xl flex items-center justify-center font-black text-xs">
                            {{ substr($task->user->name ?? 'G', 0, 1) }}
                        </div>
                        <div class="flex-grow min-w-0">
                            <p class="text-xs font-black text-gray-800 uppercase truncate">{{ $task->user->name ?? 'Guest' }}</p>
                            <p class="text-[9px] font-bold text-gray-400 uppercase mt-1">#{{ $task->order_number }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-[8px] font-black bg-red-50 text-[#CD2828] px-2 py-1 rounded-lg uppercase border border-red-100">
                                {{ $task->shipment_status }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Belum ada tugas baru</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
@endsection