@extends('layouts.admin')

@section('content')
<div class="mb-10 px-2">
    <h1 class="text-3xl font-black text-[#202020] uppercase tracking-tighter">Transaction Report</h1>
    <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Order Fulfillment & Payment Audits</p>
</div>

<div class="py-4">
    @include('admin.reports._filter')
</div>

{{-- STATS CARDS --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-2">Total Orders</h4>
        <p class="text-2xl font-black text-[#202020] tracking-tighter">{{ number_format($total) }}</p>
    </div>
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-2">Pending Log</h4>
        <p class="text-2xl font-black text-orange-400 tracking-tighter">{{ number_format($pending) }}</p>
    </div>
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm border-l-4 border-l-[#1BCFD5]">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-2">Paid Verified</h4>
        <p class="text-2xl font-black text-[#1BCFD5] tracking-tighter">{{ number_format($paid) }}</p>
    </div>
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm border-l-4 border-l-[#CD2828]">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-2">Financial Value</h4>
        <p class="text-xl font-black text-[#CD2828] tracking-tighter">Rp{{ number_format($totalValue, 0, ',', '.') }}</p>
    </div>
</div>

{{-- TABLE --}}
<div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] overflow-hidden shadow-sm">
    <table class="w-full text-left">
        <thead class="bg-[#F3F3F3] border-b-2 border-white text-[10px] font-black uppercase tracking-widest text-[#202020]">
            <tr>
                <th class="p-5 border-r-2 border-white">Order ID</th>
                <th class="p-5 text-center border-r-2 border-white">Timestamp</th>
                <th class="p-5 border-r-2 border-white">Customer Identity</th>
                <th class="p-5 text-center border-r-2 border-white">Status</th>
                <th class="p-5 text-center border-r-2 border-white">Grand Total</th>
                <th class="p-5 text-center">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#BABABA]/10 text-[11px] font-bold uppercase text-[#202020]">
            @foreach($transaction as $t)
            <tr class="hover:bg-[#F9F9F9] transition-colors">
                <td class="p-5 font-black tracking-tighter">#{{ $t->order_number }}</td>
                <td class="p-5 text-center text-[#BABABA] tracking-tighter">
                    {{ $t->created_at->format('d/m/Y') }}
                </td>
                <td class="p-5 truncate max-w-[150px]">{{ $t->user->name ?? 'GUEST USER' }}</td>
                <td class="p-5 text-center">
                    <span class="text-[9px] font-black {{ $t->payment_status == 'paid' ? 'text-[#1BCFD5]' : ($t->payment_status == 'unpaid' ? 'text-[#CD2828]' : 'text-orange-400') }}">
                        {{ strtoupper($t->payment_status) }}
                    </span>
                </td>
                <td class="p-5 text-center font-black">
                    Rp{{ number_format($t->grand_total, 0, ',', '.') }}
                </td>
                <td class="p-5 text-center">
                    <div class="flex items-center justify-center gap-4 text-[9px] font-black tracking-widest">
                        <a href="{{ route('admin.reports.transactions-show', $t->id) }}" class="text-[#1BCFD5] hover:underline">
                            DETAILS
                        </a> 
                        <span class="text-[#BABABA]/30">|</span>
                        <a href="{{ route('admin.reports.invoice', $t->id) }}" target="_blank" class="text-[#CD2828] hover:underline">
                            INVOICE
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-8">
    {{ $transaction->links() }}
</div>


@endsection