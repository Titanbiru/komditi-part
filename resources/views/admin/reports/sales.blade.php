@extends('layouts.admin')

@section('content')
<div class="mb-10 px-2">
    <h1 class="text-3xl font-black text-[#202020] uppercase tracking-tighter">Sales Report</h1>
    <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Revenue Analysis & Performance Log</p>
</div>

<div class="py-4">
    @include('admin.reports._filter')
</div>

{{-- STATS CARDS --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-2">Total SKU Sold</h4>
        <p class="text-xl font-black text-[#202020] tracking-tighter">{{ $totalProductsSold }} <span class="text-[10px] text-[#BABABA]">TYPES</span></p>
    </div>
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-2">Total Quantity</h4>
        <p class="text-xl font-black text-[#202020] tracking-tighter">{{ number_format($totalQuantitySold) }} <span class="text-[10px] text-[#BABABA]">UNITS</span></p>
    </div>
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm border-l-4 border-l-[#1BCFD5]">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-2">Total Revenue</h4>
        <p class="text-xl font-black text-[#1BCFD5] tracking-tighter">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm border-l-4 border-l-[#CD2828]">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-2">Best Seller</h4>
        <p class="text-sm font-black text-[#CD2828] truncate uppercase" title="{{ $topProduct }}">{{ $topProduct ?? 'N/A' }}</p>
    </div>
</div>

{{-- TABLE --}}
<div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] overflow-hidden shadow-sm">
    <table class="w-full text-left">
        <thead class="bg-[#F3F3F3] border-b-2 border-white text-[10px] font-black uppercase tracking-widest text-[#202020]">
            <tr>
                <th class="p-5 border-r-2 border-white">Product Item</th>
                <th class="p-5 text-center border-r-2 border-white">Qty Sold</th>
                <th class="p-5 text-center border-r-2 border-white">Unit Price</th>
                <th class="p-5 text-right">Total Sales</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#BABABA]/10 text-[11px] font-bold uppercase text-[#202020]">
            @foreach($orders as $order)
                @foreach($order->items as $item)
                <tr class="hover:bg-[#F9F9F9] transition-colors">
                    <td class="p-5 font-black tracking-tight leading-tight">
                        {{ $item->product_name_snapshot }}
                    </td>
                    <td class="p-5 text-center text-[#BABABA]">
                        {{ $item->quantity }} <span class="text-[9px]">PCS</span>
                    </td>
                    <td class="p-5 text-center">
                        Rp{{ number_format($item->product_price_snapshot, 0, ',', '.') }}
                    </td>
                    <td class="p-5 text-right font-black text-[#CD2828]">
                        Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-8">{{ $orders->links() }}</div>

@endsection