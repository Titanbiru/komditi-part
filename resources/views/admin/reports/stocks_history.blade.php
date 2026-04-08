@extends('layouts.admin')

@section('content')
<div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-6 px-2">
    <div>
        <h1 class="text-3xl font-black text-[#202020] uppercase tracking-tighter italic">Product Audit Trail</h1>
        <div class="flex items-center gap-3 mt-2">
            <span class="bg-[#CD2828] text-white text-[9px] font-black px-3 py-1 rounded-full tracking-widest">SKU: {{ $product->sku }}</span>
            <p class="text-[11px] font-black text-[#BABABA] uppercase tracking-widest">{{ $product->name }}</p>
        </div>
    </div>
    
    <a href="{{ route('admin.reports.stocks') }}" class="text-[10px] font-black text-[#BABABA] hover:text-[#CD2828] uppercase tracking-widest transition-all flex items-center gap-2 group">
        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
        Back to Inventory
    </a>
</div>

{{-- QUICK STATS --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-white border border-[#BABABA]/20 p-8 rounded-[2.5rem] shadow-sm text-center">
        <h4 class="text-[8px] font-black text-[#BABABA] uppercase tracking-[0.2em] mb-2">Live Stock Amount</h4>
        <p class="text-4xl font-black text-[#202020] tracking-tighter">{{ $product->stock }} <span class="text-[10px] text-[#BABABA]">UNITS</span></p>
    </div>
    <div class="bg-white border border-[#BABABA]/20 p-8 rounded-[2.5rem] shadow-sm text-center border-b-4 border-b-[#1BCFD5]">
        <h4 class="text-[8px] font-black text-[#BABABA] uppercase tracking-[0.2em] mb-2">Total Inbound</h4>
        <p class="text-3xl font-black text-[#1BCFD5] tracking-tighter">{{ $histories->where('type', 'in')->sum('amount') }}</p>
    </div>
    <div class="bg-white border border-[#BABABA]/20 p-8 rounded-[2.5rem] shadow-sm text-center border-b-4 border-b-[#CD2828]">
        <h4 class="text-[8px] font-black text-[#BABABA] uppercase tracking-[0.2em] mb-2">Total Outbound</h4>
        <p class="text-3xl font-black text-[#CD2828] tracking-tighter">{{ $histories->where('type', 'out')->sum('amount') }}</p>
    </div>
</div>

{{-- TABLE --}}
<div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] overflow-hidden shadow-sm">
    <div class="px-8 py-5 bg-[#F3F3F3] border-b-2 border-white flex justify-between items-center">
        <h3 class="text-[10px] font-black uppercase tracking-widest text-[#202020]">Movement Records</h3>
        <span class="text-[8px] font-black bg-white px-4 py-1 rounded-full text-[#BABABA] border border-[#BABABA]/5 uppercase">{{ $histories->total() }} Entries</span>
    </div>
    
    <table class="w-full text-left">
        <thead class="bg-[#F9F9F9] border-b border-[#BABABA]/10 text-[9px] font-black uppercase tracking-widest text-[#BABABA]">
            <tr>
                <th class="px-8 py-5">Timestamp</th>
                <th class="px-8 py-5">Executor</th>
                <th class="px-8 py-5 text-center">Type</th>
                <th class="px-8 py-5 text-center">Quantity</th>
                <th class="px-8 py-5 text-center">Flow</th>
                <th class="px-8 py-5">Reason/Note</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#BABABA]/10 text-[11px] font-bold uppercase tracking-tight text-[#202020]">
            @forelse($histories as $h)
            <tr class="hover:bg-[#F9F9F9] transition-colors">
                <td class="px-8 py-5 text-[#BABABA]">{{ $h->created_at->format('d/m/Y • H:i') }}</td>
                <td class="px-8 py-5 font-black">{{ $h->user->name ?? 'SYSTEM' }}</td>
                <td class="px-8 py-5 text-center">
                    <span class="text-[8px] font-black px-3 py-1 rounded-lg {{ $h->type == 'in' ? 'text-[#1BCFD5] bg-cyan-50' : 'text-[#CD2828] bg-red-50' }}">
                        {{ strtoupper($h->type) }}
                    </span>
                </td>
                <td class="px-8 py-5 text-center font-black {{ $h->type == 'in' ? 'text-[#1BCFD5]' : 'text-[#CD2828]' }}">
                    {{ $h->type == 'in' ? '+' : '-' }}{{ $h->amount }}
                </td>
                <td class="px-8 py-5 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <span class="text-[#BABABA] font-medium">{{ $h->stock_before }}</span>
                        <svg class="w-3 h-3 text-[#BABABA] opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke-width="3" stroke-linecap="round"/></svg>
                        <span class="font-black">{{ $h->stock_after }}</span>
                    </div>
                </td>
                <td class="px-8 py-5 text-[#BABABA] text-[9px] italic lowercase leading-relaxed">
                    {{ $h->note ?? 'no remarks' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="py-20 text-center">
                    <p class="text-[10px] font-black text-[#BABABA] uppercase tracking-[0.3em]">No historical movement recorded</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-8">
    {{ $histories->links() }}
</div>
@endsection