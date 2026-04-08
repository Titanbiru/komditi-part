@extends('layouts.staff')

@section('content')
<div class="mb-10 px-2">
    <h1 class="text-3xl font-black text-[#202020] uppercase tracking-tighter">Transaction Report</h1>
    <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Financial & Fulfillment Log</p>
</div>

<div class="py-4">
    @include('staff.reports._filter')
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-1">Total Orders</h4>
        <p class="text-3xl font-black text-[#202020]">{{ $total }}</p>
    </div>
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-1">Pending</h4>
        <p class="text-3xl font-black text-orange-400">{{ $pending }}</p>
    </div>
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm border-l-4 border-l-[#1BCFD5]">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-1">Paid</h4>
        <p class="text-3xl font-black text-[#1BCFD5]">{{ $paid }}</p>
    </div>
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm border-l-4 border-l-[#CD2828]">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-1">Total Value</h4>
        <p class="text-xl font-black text-[#CD2828] tracking-tighter">Rp{{ number_format($totalValue, 0, ',', '.') }}</p>
    </div>
</div>

<div class="bg-white border border-[#BABABA]/20 rounded-[2rem] overflow-hidden shadow-sm">
    <table class="min-w-full">
        <thead class="bg-[#F3F3F3] border-b-2 border-white text-[10px] font-black uppercase tracking-widest text-[#202020]">
            <tr>
                <th class="p-5 text-left border-r-2 border-white">Order ID</th>
                <th class="p-5 text-center border-r-2 border-white">Date</th>
                <th class="p-5 text-left border-r-2 border-white">Customer</th>
                <th class="p-5 text-center border-r-2 border-white">Payment</th>
                <th class="p-5 text-center border-r-2 border-white">Total</th>
                <th class="p-5 text-center">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#BABABA]/10 text-[11px] font-bold uppercase text-[#202020]">
            @foreach($transaction as $t)
            <tr class="hover:bg-[#F9F9F9] transition-colors">
                <td class="p-5 font-black tracking-tighter">{{ $t->order_number }}</td>
                <td class="p-5 text-center text-[#BABABA]">{{ $t->created_at->format('d/m/Y') }}</td>
                <td class="p-5 text-[#202020] truncate max-w-[120px]">{{ $t->user->name ?? 'GUEST' }}</td>
                <td class="p-5 text-center">
                    <span class="text-[9px] font-black {{ $t->payment_status == 'paid' ? 'text-[#1BCFD5]' : ($t->payment_status == 'unpaid' ? 'text-[#CD2828]' : 'text-orange-400') }}">
                        {{ strtoupper($t->payment_status) }}
                    </span>
                </td>
                <td class="p-5 text-center font-black">Rp{{ number_format($t->grand_total, 0, ',', '.') }}</td>
                <td class="p-5 text-center">
                    <div class="flex items-center justify-center gap-3">
                        <a href="{{ route('staff.reports.transaction_detail', $t->id) }}" class="text-[#1BCFD5] hover:underline text-[9px] font-black tracking-widest">DETAILS</a>
                        <span class="text-[#BABABA]/30">|</span>
                        <a href="{{ route('admin.reports.invoice', $t->id) }}" target="_blank" class="text-[#CD2828] hover:underline text-[9px] font-black tracking-widest">INVOICE</a>
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