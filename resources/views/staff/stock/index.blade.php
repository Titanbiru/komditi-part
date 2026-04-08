@extends('layouts.staff')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6 px-2">
    <div>
        <h1 class="text-3xl font-black text-[#202020] uppercase tracking-tighter">Manage Stock</h1>
        <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-[0.2em] mt-1">Inventory Control System</p>
    </div>
    <div class="relative w-full md:w-80">
        <form action="{{ route('staff.stock.index') }}" method="GET">
            <input type="text" name="search" placeholder="SEARCH PRODUCT..." value="{{ request('search') }}"
                class="w-full border-2 border-[#BABABA]/20 rounded-2xl px-5 py-3 text-[11px] font-black uppercase focus:outline-none focus:border-[#CD2828] bg-white transition-all">
        </form>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
    <div class="border border-[#BABABA]/20 rounded-2xl p-5 bg-white shadow-sm">
        <h3 class="text-[9px] font-black text-[#BABABA] uppercase mb-2 tracking-widest">Total SKU</h3>
        <p class="text-2xl font-black text-[#202020]">{{ $totalProducts }}</p>
    </div>
    <div class="border border-[#BABABA]/20 rounded-2xl p-5 bg-white shadow-sm">
        <h3 class="text-[9px] font-black text-[#BABABA] uppercase mb-2 tracking-widest">Safe</h3>
        <p class="text-2xl font-black text-[#1BCFD5]">{{ $safeStock }}</p>
    </div>
    <div class="border border-[#BABABA]/20 rounded-2xl p-5 bg-white shadow-sm">
        <h3 class="text-[9px] font-black text-[#BABABA] uppercase mb-2 tracking-widest">Empty</h3>
        <p class="text-2xl font-black text-[#CD2828]">{{ $emptyStock }}</p>
    </div>
    <div class="border border-[#BABABA]/20 rounded-2xl p-5 bg-white shadow-sm border-l-4 border-l-orange-400">
        <h3 class="text-[9px] font-black text-[#BABABA] uppercase mb-2 tracking-widest">Low Stock</h3>
        <p class="text-2xl font-black text-orange-400">{{ $runningLow }}</p>
    </div>
</div>

<div class="bg-white rounded-[2rem] border border-[#BABABA]/20 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-[#F3F3F3] border-b-2 border-black">
                <tr>
                    <th class="px-8 py-4 text-left text-[10px] font-black text-black uppercase tracking-widest border-r-2 border-white">Product</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-black uppercase tracking-widest border-r-2 border-white">SKU</th>
                    <th class="px-6 py-4 text-center text-[10px] font-black text-black uppercase tracking-widest border-r-2 border-white">Current Stock</th>
                    <th class="px-6 py-4 text-center text-[10px] font-black text-black uppercase tracking-widest border-r-2 border-white">Status</th>
                    <th class="px-6 py-4 text-center text-[10px] font-black text-black uppercase tracking-widest">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y-2 divide-gray-50 text-[11px] font-bold uppercase">
                @forelse($products as $p)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-8 py-5 text-[#202020] font-black">{{ $p->name }}</td>
                    <td class="px-6 py-5 text-[#BABABA] tracking-tighter">{{ $p->sku }}</td>
                    <td class="px-6 py-5 text-center font-black text-[#202020]">{{ $p->stock }}</td>
                    <td class="px-6 py-5 text-center">
                        <span class="px-3 py-1 rounded-lg text-[9px] font-black 
                            {{ $p->stock == 0 ? 'bg-red-100 text-[#CD2828] border border-red-200' : ($p->stock < 10 ? 'bg-orange-100 text-orange-600 border border-orange-200' : 'bg-green-100 text-[#1BCFD5] border border-green-200') }}">
                            {{ $p->stock == 0 ? 'EMPTY' : ($p->stock < 10 ? 'LOW STOCK' : 'SAFE') }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('staff.stock.edit', $p->id) }}" class="bg-black text-white px-4 py-2 rounded-xl text-[9px] font-black hover:bg-[#CD2828] transition-all">UPDATE</a>
                            <a href="{{ route('staff.stock.history', $p->id) }}" class="bg-gray-100 text-black px-4 py-2 rounded-xl text-[9px] font-black hover:bg-gray-200 transition-all">LOGS</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-20 text-center">
                        <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.5em]">Inventory record empty</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-8 py-6 bg-[#F9F9F9]/50 border-t border-[#BABABA]/10">
        {{ $products->links() }}
    </div>
</div>
@endsection