@extends('layouts.admin')

@section('content')
<div class="mb-10 px-2">
    <h1 class="text-3xl font-black text-[#202020] uppercase tracking-tighter">Inventory Report</h1>
    <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Real-time Stock Levels & Movement History</p>
</div>

<div class="py-4">
    @include('admin.reports._filter')
</div>

{{-- STATS CARDS --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-2">Total Master SKU</h4>
        <p class="text-2xl font-black text-[#202020] tracking-tighter">{{ $totalProducts }}</p>
    </div>
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm border-l-4 border-l-green-400">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-2">Inbound Units</h4>
        <p class="text-2xl font-black text-green-500 tracking-tighter">{{ number_format($stockIn) }}</p>
    </div>
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm border-l-4 border-l-orange-400">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-2">Outbound Units</h4>
        <p class="text-2xl font-black text-orange-400 tracking-tighter">{{ number_format($stockOut) }}</p>
    </div>
    <div class="bg-white border border-[#BABABA]/20 p-6 rounded-[2rem] shadow-sm border-l-4 border-l-[#CD2828]">
        <h4 class="text-[#BABABA] font-black text-[9px] uppercase tracking-widest mb-2">Critically Low</h4>
        <p class="text-2xl font-black text-[#CD2828] tracking-tighter">{{ $outOfStockProducts }} <span class="text-[10px] text-[#BABABA]">SKU</span></p>
    </div>
</div>

{{-- TABLE MOVEMENT LOGS --}}
<div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] overflow-hidden shadow-sm">
    <div class="px-8 py-4 bg-[#F3F3F3] border-b-2 border-white text-[10px] font-black uppercase tracking-widest text-[#202020]">Stock Movement Logs</div>
    <table class="w-full text-left">
        <thead class="bg-[#F9F9F9] border-b border-[#BABABA]/10 text-[9px] font-black uppercase tracking-widest text-[#BABABA]">
            <tr>
                <th class="p-5 border-r border-[#BABABA]/5">Product Name</th>
                <th class="p-5 text-center border-r border-[#BABABA]/5">Entry Type</th>
                <th class="p-5 text-center border-r border-[#BABABA]/5">Quantity</th>
                <th class="p-5 text-center border-r border-[#BABABA]/5">Activity Date</th>
                <th class="p-5 text-center">Action</th> 
            </tr>
        </thead>
        <tbody class="divide-y divide-[#BABABA]/10 text-[11px] font-bold uppercase text-[#202020]">
            @foreach($stockHistory as $history)
            <tr class="hover:bg-[#F9F9F9] transition-colors group">
                <td class="p-5 font-black tracking-tight leading-tight uppercase">{{ $history->product_name }}</td>
                <td class="p-5 text-center">
                    <span class="px-3 py-1 rounded-lg text-[8px] font-black {{ $history->change_type == 'in' ? 'bg-blue-50 text-blue-500' : 'bg-orange-50 text-orange-500' }}">
                        {{ strtoupper($history->change_type) }}
                    </span>
                </td>
                <td class="p-5 text-center font-black">{{ number_format($history->quantity) }} <span class="text-[9px] text-[#BABABA]">PCS</span></td>
                <td class="p-5 text-center text-[#BABABA] tracking-tighter">
                    {{ date('d/m/y • H:i', strtotime($history->created_at)) }}
                </td>
                <td class="p-5 text-center">
                    {{-- Tombol Action: Log Histori --}}
                    <div class="flex justify-center">
                        <a href="{{ route('admin.reports.stocks_history', ['product' => $history->product_id]) }}" 
                            class="text-[9px] font-black text-[#1BCFD5] uppercase tracking-widest hover:underline hover:text-[#202020] transition-colors">
                            History Logs
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-8">
    {{ $stockHistory->links() }}
</div>
@endsection