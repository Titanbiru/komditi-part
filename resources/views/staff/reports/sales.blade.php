@extends('layouts.staff')

@section('content')
<div class="mb-10 px-2">
    <h1 class="text-3xl font-black text-[#202020] uppercase tracking-tighter">Sales Report</h1>
    <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Revenue & Performance Analytics</p>
</div>

<div class="py-4">
    @include('staff.reports._filter')
</div>

{{-- CARDS --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-2">Total Revenue</h4>
        <p class="text-xl font-black text-[#CD2828] tracking-tighter">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-2">Qty Sold</h4>
        <p class="text-xl font-black text-[#202020] tracking-tighter">{{ number_format($totalQuantitySold) }} <span class="text-[10px] text-[#BABABA]">PCS</span></p>
    </div>
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-2">Unique SKU</h4>
        <p class="text-xl font-black text-[#202020] tracking-tighter">{{ $totalProductsSold }} <span class="text-[10px] text-[#BABABA]">TYPES</span></p>
    </div>
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm border-l-4 border-l-[#1BCFD5]">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-2">Best Seller</h4>
        <p class="text-sm font-black text-[#1BCFD5] truncate uppercase">{{ $topProduct ?? 'N/A' }}</p>
    </div>
</div>

{{-- TABLE --}}
<div class="bg-white border border-[#BABABA]/20 rounded-[2rem] overflow-hidden shadow-sm">
    <table class="w-full text-left">
        <thead class="bg-[#F3F3F3] border-b-2 border-white text-[10px] font-black uppercase tracking-widest text-[#202020]">
            <tr>
                <th class="p-5 border-r-2 border-white">Order ID</th>
                <th class="p-5 border-r-2 border-white">Customer</th>
                <th class="p-5 border-r-2 border-white">Total Amount</th>
                <th class="p-5">Date</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#BABABA]/10 text-[11px] font-bold uppercase text-[#202020]">
            @foreach($orders as $order)
            <tr class="hover:bg-[#F9F9F9] transition-colors">
                <td class="p-5 font-black">#{{ $order->order_number ?? $order->id }}</td>
                <td class="p-5 text-[#BABABA]">{{ $order->user->name ?? 'GUEST' }}</td>
                <td class="p-5 font-black text-[#1BCFD5]">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</td>
                <td class="p-5 text-[#BABABA] tracking-tighter">{{ $order->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-8">{{ $orders->links() }}</div>
@endsection