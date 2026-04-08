@extends('layouts.admin')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 text-center">
            <h3 class="text-xs font-black uppercase text-gray-400 mb-3 tracking-widest">Team & Customers</h3>
            <p class="text-2xl font-black text-[#CD2828]">
                {{ $totalAdmins }}<span class="text-gray-300 mx-1">/</span>{{ $totalStaff }}<span class="text-gray-300 mx-1">/</span>{{ $totalCustomers }}
            </p>
            <p class="text-[9px] font-bold text-gray-400 uppercase mt-2">Admin / Staff / User</p>
        </div>

        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 text-center">
            <h3 class="text-xs font-black uppercase text-gray-400 mb-3 tracking-widest">Sales This Month</h3>
            <p class="text-2xl font-black text-[#CD2828]">
                Rp {{ number_format($salesThisMonth, 0, ',', '.') }}
            </p>
            <p class="text-[9px] font-bold text-gray-400 uppercase mt-2">Total Pendapatan (Paid)</p>
        </div>

        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 text-center">
            <h3 class="text-xs font-black uppercase text-gray-400 mb-3 tracking-widest">Inventory</h3>
            <p class="text-2xl font-black text-[#CD2828]">{{ $totalProducts }}</p>
            <p class="text-[9px] font-bold text-gray-400 uppercase mt-2">Total Produk Aktif</p>
        </div>

        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 text-center">
            <h3 class="text-xs font-black uppercase text-gray-400 mb-3 tracking-widest">Transactions</h3>
            <p class="text-2xl font-black text-[#CD2828]">{{ $totalOrdersMonth }}</p>
            <p class="text-[9px] font-bold text-gray-400 uppercase mt-2">Order Bulan Ini</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    
        <div class="bg-white rounded-[2rem] border-2 border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center bg-red-50/30">
                <h3 class="text-[11px] font-black text-[#CD2828] uppercase tracking-[0.2em]">Stok Hampir Habis</h3>
                <span class="text-[9px] font-black bg-[#CD2828] text-white px-2 py-1 rounded-lg uppercase">Action Needed</span>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($lowStockProducts as $low)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-transparent hover:border-red-100 transition-all">
                        <div class="min-w-0 flex-grow">
                            <p class="text-xs font-black text-gray-800 uppercase truncate">{{ $low->name }}</p>
                            <p class="text-[9px] font-bold text-gray-400 mt-1 uppercase">Sisa Stok: <span class="text-[#CD2828]">{{ $low->stock }} Unit</span></p>
                        </div>
                        <div class="ml-4 px-3 py-1.5 bg-orange-100 text-orange-600 rounded-xl text-[8px] font-black uppercase">
                            LOW
                        </div>
                    </div>
                    @empty
                    <p class="text-center py-10 text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">Stok masih aman.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] border-2 border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center">
                <h3 class="text-[11px] font-black text-gray-800 uppercase tracking-[0.2em]">Transaksi Terbaru</h3>
                <a href="{{ route('admin.reports.transactions') }}" class="text-[9px] font-black text-gray-400 uppercase hover:text-black transition-all underline decoration-2 underline-offset-4">Lihat Semua</a>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recentOrders as $ro)
                    <div class="flex items-center gap-4 p-4 border-b border-gray-50 last:border-0 hover:bg-gray-50/50 rounded-2xl transition-all">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center font-black text-gray-400 text-xs">
                            {{ substr($ro->user->name ?? 'U', 0, 1) }}
                        </div>
                        <div class="flex-grow min-w-0">
                            <p class="text-xs font-black text-gray-800 uppercase truncate">{{ $ro->user->name ?? 'Guest' }}</p>
                            <p class="text-[9px] font-bold text-gray-400 mt-1 uppercase">Order #{{ $ro->order_number }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-xs font-black text-[#202020]">Rp{{ number_format($ro->grand_total, 0, ',', '.') }}</p>
                            <span class="text-[8px] font-black uppercase {{ $ro->payment_status == 'paid' ? 'text-green-500' : 'text-red-500' }}">
                                {{ $ro->payment_status }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <p class="text-center py-10 text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">Belum ada transaksi hari ini.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
@endsection