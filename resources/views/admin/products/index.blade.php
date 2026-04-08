@extends('layouts.admin')

@section('content')
<div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 px-2">
    <div>
        <h1 class="text-3xl font-black text-[#CD2828] uppercase tracking-tighter">Product Master</h1>
        <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Manage Inventory & Pricing</p>
    </div>
    <div class="flex items-center gap-3 bg-white p-2 rounded-2xl border border-[#BABABA]/20 shadow-sm">
        <div class="text-right">
            <p class="text-[10px] font-black text-[#202020] uppercase leading-none">{{ auth()->user()->name }}</p>
            <p class="text-[8px] font-bold text-[#BABABA] uppercase tracking-widest">Administrator</p>
        </div>
        <div class="w-8 h-8 bg-[#CD2828] rounded-xl flex items-center justify-center text-white font-black text-xs uppercase">
            {{ substr(auth()->user()->name, 0, 1) }}
        </div>
    </div>
</div>

<div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] overflow-hidden shadow-sm mb-12">
    <div class="flex flex-col lg:flex-row justify-between items-center px-8 py-6 bg-[#F3F3F3] border-b-2 border-white gap-6">
        <div class="relative w-full lg:w-auto">
            <form action="{{ route('admin.products.index') }}" method="GET">
                <input type="text" name="search" placeholder="SEARCH PRODUCT / CATEGORY..." value="{{ request('search') }}"
                    class="bg-white border border-[#BABABA]/10 rounded-xl px-5 py-3 text-[10px] font-black uppercase focus:outline-none focus:border-[#CD2828] w-full lg:w-96 shadow-sm">
            </form>
        </div>
        <div class="flex gap-3 w-full lg:w-auto">
            <a href="{{ route('admin.categories.index') }}" class="flex-1 lg:flex-none bg-white border border-[#CD2828] text-[#CD2828] px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-50 transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                Categories
            </a>
            <a href="{{ route('admin.products.create') }}" class="flex-1 lg:flex-none bg-[#1BCFD5] text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#202020] transition-all flex items-center justify-center gap-2 shadow-lg shadow-cyan-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="3" stroke-linecap="round"/></svg>
                Add Product
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#F9F9F9] border-b border-[#BABABA]/10 text-[9px] font-black uppercase text-[#BABABA] tracking-widest">
                <tr>
                    <th class="px-8 py-5 text-left border-r border-[#BABABA]/5">Product Identity</th>
                    <th class="px-8 py-5 text-left border-r border-[#BABABA]/5">SKU / Code</th>
                    <th class="px-8 py-5 text-center border-r border-[#BABABA]/5">Price Details</th>
                    <th class="px-8 py-5 text-center border-r border-[#BABABA]/5">Stock</th>
                    <th class="px-8 py-5 text-center border-r border-[#BABABA]/5">Status</th>
                    <th class="px-8 py-5 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#BABABA]/10 text-[11px] font-bold uppercase text-[#202020]">
                @forelse($products as $p)
                <tr class="hover:bg-[#F9F9F9] transition-colors">
                    <td class="px-8 py-5">
                        <p class="font-black text-[#202020] tracking-tight">{{ $p->name }}</p>
                        <p class="text-[8px] text-[#BABABA] tracking-widest mt-1">{{ $p->categories->pluck('name')->implode(', ') ?: 'NO CATEGORY' }}</p>
                    </td>
                    <td class="px-8 py-5 text-[#BABABA] tracking-tighter">{{ $p->sku }}</td>
                    <td class="px-8 py-5 text-center">
                        @if($p->discount > 0)
                            @php $finalPrice = $p->price - ($p->price * $p->discount / 100); @endphp
                            <p class="font-black text-[#202020]">Rp{{ number_format($finalPrice, 0, ',', '.') }}</p>
                            <p class="text-[8px] text-[#CD2828] font-black">DISC {{ $p->discount }}% OFF</p>
                        @else
                            <p class="font-black text-[#202020]">Rp{{ number_format($p->price, 0, ',', '.') }}</p>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-center font-black {{ $p->stock <= 5 ? 'text-[#CD2828]' : 'text-[#202020]' }}">
                        {{ $p->stock }}
                    </td>
                    <td class="px-8 py-5 text-center">
                        <span class="px-3 py-1 rounded-lg text-[8px] font-black {{ $p->status == 'active' ? 'bg-green-50 text-green-500' : 'bg-orange-50 text-orange-400' }}">
                            {{ strtoupper($p->status) }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-center">
                        <div class="flex items-center justify-center gap-4 text-[9px] font-black tracking-widest">
                            <a href="{{ route('admin.products.show', $p) }}" class="text-[#BABABA] hover:text-[#202020] transition-all">SHOW</a>
                            <a href="{{ route('admin.products.edit', $p) }}" class="text-[#1BCFD5] hover:underline">EDIT</a>
                            <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('DELETE PRODUCT?')" class="text-[#CD2828] hover:underline">DEL</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-8 py-12 text-center text-[#BABABA] text-[10px] font-black uppercase tracking-widest">No Products Found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-8 py-5 bg-[#F9F9F9]/50 border-t border-[#BABABA]/10 text-right">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
@endsection