@extends('layouts.staff')

@section('content')
<div class="mb-10 px-2">
    <h1 class="text-3xl font-black text-[#202020] uppercase tracking-tighter">Inventory Report</h1>
    <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Stock Level & Movement Logs</p>
</div>

<div class="py-4">
    @include('staff.reports._filter')
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-2">Total Items</h4>
        <p class="text-2xl font-black text-[#202020]">{{ $totalProducts }}</p>
    </div>
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm border-l-4 border-l-green-400">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-2">In Stock</h4>
        <p class="text-2xl font-black text-green-500">{{ $stockIn }}</p>
    </div>
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm border-l-4 border-l-orange-400">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-2">Out of Stock</h4>
        <p class="text-2xl font-black text-orange-400">{{ $stockOut }}</p>
    </div>
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm border-l-4 border-l-[#CD2828]">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-2">Restock Alert</h4>
        <p class="text-2xl font-black text-[#CD2828]">{{ $outOfStockProducts }} <span class="text-[10px] text-[#BABABA]">SKU</span></p>
    </div>
</div>

<div class="bg-white border border-[#BABABA]/20 rounded-[2rem] overflow-hidden shadow-sm">
    <div class="px-8 py-4 bg-[#F3F3F3] border-b-2 border-white text-[10px] font-black uppercase tracking-widest text-[#202020]">Stock Movement History</div>
    <table class="w-full text-left">
        <thead class="bg-[#F9F9F9] border-b border-[#BABABA]/10 text-[9px] font-black uppercase tracking-widest text-[#BABABA]">
            <tr>
                <th class="p-5 border-r border-[#BABABA]/5">Product Name</th>
                <th class="p-5 text-center border-r border-[#BABABA]/5">Type</th>
                <th class="p-5 text-center border-r border-[#BABABA]/5">Qty</th>
                <th class="p-5 text-right">Timestamp</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#BABABA]/10 text-[11px] font-bold uppercase text-[#202020]">
            @foreach($stockHistory as $history)
            <tr class="hover:bg-[#F9F9F9]">
                <td class="p-5 font-black">{{ $history->product_name }}</td>
                <td class="p-5 text-center">
                    <span class="px-3 py-1 rounded-lg text-[8px] font-black {{ $history->change_type == 'in' ? 'bg-blue-50 text-blue-500' : 'bg-orange-50 text-orange-500' }}">
                        {{ strtoupper($history->change_type) }}
                    </span>
                </td>
                <td class="p-5 text-center font-black">{{ $history->quantity }}</td>
                <td class="p-5 text-right text-[#BABABA] tracking-tighter">{{ date('d/m/y H:i', strtotime($history->created_at)) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-8">{{ $stockHistory->links() }}</div>
@endsection