@extends('layouts.staff')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6 px-2">
    <div>
        <h1 class="text-3xl font-black text-[#202020] uppercase tracking-tighter">Transaction</h1>
        <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Order Monitoring System</p>
    </div>
    <div class="relative w-full md:w-80">
        <form action="{{ route('staff.transactions.index') }}" method="GET">
            <input type="text" name="search" placeholder="SEARCH ORDER ID / CUSTOMER..." value="{{ request('search') }}"
                class="w-full border-2 border-[#BABABA]/20 rounded-2xl px-5 py-3 text-[11px] font-black uppercase focus:outline-none focus:border-[#CD2828] bg-white transition-all shadow-sm">
        </form>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
    <div class="border border-[#BABABA]/20 rounded-2xl p-5 bg-white shadow-sm">
        <h3 class="text-[9px] font-black text-[#BABABA] uppercase mb-2 tracking-widest">Total Orders</h3>
        <p class="text-2xl font-black text-[#202020]">{{ $totalTransaction }}</p>
    </div>
    <div class="border border-[#BABABA]/20 rounded-2xl p-5 bg-white shadow-sm border-l-4 border-l-orange-400">
        <h3 class="text-[9px] font-black text-[#BABABA] uppercase mb-2 tracking-widest">Pending</h3>
        <p class="text-2xl font-black text-orange-400">{{ $pendingTransaction }}</p>
    </div>
    <div class="border border-[#BABABA]/20 rounded-2xl p-5 bg-white shadow-sm border-l-4 border-l-[#1BCFD5]">
        <h3 class="text-[9px] font-black text-[#BABABA] uppercase mb-2 tracking-widest">Paid</h3>
        <p class="text-2xl font-black text-[#1BCFD5]">{{ $paidTransaction }}</p>
    </div>
    <div class="border border-[#BABABA]/20 rounded-2xl p-5 bg-white shadow-sm border-l-4 border-l-[#202020]">
        <h3 class="text-[9px] font-black text-[#BABABA] uppercase mb-2 tracking-widest">Shipping</h3>
        <p class="text-2xl font-black text-[#202020]">{{ $processingShipment }}</p>
    </div>
</div>

<div class="bg-white rounded-[2rem] border border-[#BABABA]/20 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-[#F3F3F3] border-b-2 border-black">
                <tr>
                    <th class="px-8 py-4 text-left text-[10px] font-black text-black uppercase tracking-widest border-r-2 border-white">Order ID</th>
                    <th class="px-6 py-4 text-center text-[10px] font-black text-black uppercase tracking-widest border-r-2 border-white">Date</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-black uppercase tracking-widest border-r-2 border-white">Customer</th>
                    <th class="px-6 py-4 text-center text-[10px] font-black text-black uppercase tracking-widest border-r-2 border-white">Payment</th>
                    <th class="px-6 py-4 text-center text-[10px] font-black text-black uppercase tracking-widest border-r-2 border-white">Shipment</th>
                    <th class="px-6 py-4 text-center text-[10px] font-black text-black uppercase tracking-widest">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y-2 divide-gray-50 text-[11px] font-bold uppercase">
                @forelse($transactions as $t)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-8 py-5 text-[#202020] font-black tracking-tighter">{{ $t->order_number }}</td>
                    <td class="px-6 py-5 text-center text-[#BABABA]">{{ $t->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-5 text-[#202020] truncate max-w-[150px]">{{ $t->user->name }}</td>
                    <td class="px-6 py-5 text-center">
                        <span class="px-3 py-1 rounded-lg text-[9px] font-black 
                            {{ $t->payment_status == 'paid' ? 'bg-green-50 text-[#1BCFD5] border border-green-100' : 'bg-red-50 text-[#CD2828] border border-red-100' }}">
                            {{ strtoupper($t->payment_status) }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-center text-gray-400">
                        {{ $t->shipment_status }}
                    </td>
                    <td class="px-6 py-5 text-center">
                        <div class="flex justify-center gap-3">
                            {{-- TOMBOL MANAGE --}}
                            <a href="{{ route('staff.transactions.edit', $t->id) }}" 
                            class="bg-black text-[#FEFEFE] px-4 py-2 rounded-xl text-[9px] font-black hover:bg-[#CD2828] transition-all flex items-center gap-2 uppercase tracking-widest">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                                </svg>
                                Manage
                            </a>

                            {{-- TOMBOL INVOICE --}}
                            <a href="{{ route('staff.transactions.show', $t->id) }}" target="_blank" 
                            class="bg-[#F9F9F9] text-[#BABABA] px-4 py-2 rounded-xl text-[9px] font-black hover:text-[#202020] border border-[#BABABA]/20 transition-all flex items-center gap-2 uppercase tracking-widest">
                                Invoice
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="py-20 text-center text-[10px] font-black text-[#BABABA] tracking-[0.3em]">NO TRANSACTIONS FOUND</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-8 py-6 bg-[#F9F9F9]/50 border-t border-[#BABABA]/10">
        {{ $transactions->links() }}
    </div>
</div>
@endsection