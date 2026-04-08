@extends('layouts.staff') {{-- Atau staff sesuai route --}}

@section('content')
<div class="mb-10 flex justify-between items-end px-2">
    <div>
        <h1 class="text-3xl font-black text-[#202020] uppercase tracking-tighter">Stock Logs</h1>
        <p class="text-[10px] font-bold text-[#BABABA] uppercase underline tracking-widest mt-1">{{ $product->name }} • {{ $product->sku }}</p>
    </div>
    <a href="{{ route('staff.stock.index') }}" class="text-[10px] font-black text-[#BABABA] hover:text-[#202020] uppercase tracking-widest pb-1 border-b-2 border-transparent hover:border-[#202020] transition-all">
        ← BACK
    </a>
</div>

<div class="bg-white border border-[#BABABA]/20 rounded-[2rem] overflow-hidden shadow-sm">
    <table class="min-w-full">
        <thead class="bg-[#F9F9F9] border-b border-[#BABABA]/20 text-[9px] font-black uppercase tracking-widest text-[#BABABA]">
            <tr>
                <th class="px-8 py-5 text-left">Date & Time</th>
                <th class="px-8 py-5 text-left">Staff</th>
                <th class="px-8 py-5 text-center">Type</th>
                <th class="px-8 py-5 text-center">Amount</th>
                <th class="px-8 py-5 text-center">Stock Change</th>
                <th class="px-8 py-5 text-left">Note</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#BABABA]/10 text-[11px] font-bold uppercase tracking-tight">
            @forelse($histories as $h)
            <tr class="hover:bg-[#F9F9F9]/50 transition-colors">
                <td class="px-8 py-5 text-[#BABABA]">{{ $h->created_at->format('d/m/y • H:i') }}</td>
                <td class="px-6 py-5 text-[#202020] font-black">{{ $h->user->name ?? 'SYSTEM' }}</td>
                <td class="px-6 py-5 text-center">
                    <span class="text-[9px] font-black px-2 py-0.5 rounded {{ $h->type == 'in' ? 'text-[#1BCFD5] bg-green-50' : 'text-[#CD2828] bg-red-50' }}">
                        {{ $h->type == 'in' ? 'IN' : 'OUT' }}
                    </span>
                </td>
                <td class="px-6 py-5 text-center font-black {{ $h->type == 'in' ? 'text-[#1BCFD5]' : 'text-[#CD2828]' }}">
                    {{ $h->type == 'in' ? '+' : '-' }}{{ $h->amount }}
                </td>
                <td class="px-6 py-5 text-center">
                    <span class="text-[#BABABA] font-medium">{{ $h->stock_before }}</span>
                    <span class="mx-2 text-[#202020]">→</span>
                    <span class="font-black text-[#202020]">{{ $h->stock_after }}</span>
                </td>
                <td class="px-8 py-5 text-[#BABABA] text-[10px]">{{ $h->note ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="6" class="py-20 text-center text-[10px] font-black text-[#BABABA] tracking-widest">NO HISTORY LOGS</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection