@extends('layouts.staff')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-black text-[#202020] uppercase tracking-tighter">Product Inventory</h1>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Manage and monitor your stock items</p>
    </div>
    <div class="flex items-center gap-3 bg-white p-2 rounded-2xl border-2 border-gray-100 shadow-sm">
        <span class="text-[10px] font-black uppercase text-gray-400 ml-2">Staff:</span>
        <span class="px-4 py-1 bg-black text-white text-[10px] rounded-xl font-black uppercase">{{ auth()->user()->name }}</span>
    </div>
</div>

<div class="bg-white rounded-[2rem] shadow-sm border-2 border-gray-100 overflow-hidden">
    <div class="flex flex-col md:flex-row justify-between items-center px-8 py-6 border-b border-gray-100 gap-4">
        <div class="relative w-full md:w-80">
            <form action="{{ route('staff.products.index') }}" method="GET">
                <input type="text" name="search" placeholder="SEARCH PRODUCT..." value="{{ request('search') }}"
                    class="w-full border-2 border-gray-100 rounded-2xl px-5 py-3 text-[11px] font-black uppercase focus:outline-none focus:border-[#CD2828] transition-all">
            </form>
            <p class="text-[9px] font-bold text-gray-300 mt-2 uppercase tracking-widest px-2">*Find by category or name</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-[#F3F3F3] border-b-2 border-black">
                <tr>
                    <th class="px-8 py-4 text-left text-[10px] font-black text-black uppercase tracking-widest border-r-2 border-white">Product</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-black uppercase tracking-widest border-r-2 border-white">SKU</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-black uppercase tracking-widest border-r-2 border-white">Price</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-black uppercase tracking-widest border-r-2 border-white">Stock</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-black uppercase tracking-widest border-r-2 border-white">Status</th>
                    <th class="px-6 py-4 text-center text-[10px] font-black text-black uppercase tracking-widest">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y-2 divide-gray-50 text-[11px] font-bold uppercase">
                @forelse($products as $p)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-8 py-5 text-[#202020] font-black">{{ $p->name }}</td>
                        <td class="px-6 py-5 text-gray-400 font-black">{{ $p->sku }}</td>
                        <td class="px-6 py-5">
                            @php $finalPrice = $p->discount > 0 ? $p->price - ($p->price * $p->discount / 100) : $p->price; @endphp
                            <div class="flex flex-col">
                                <span class="text-[12px] text-[#202020] font-black">Rp {{ number_format($finalPrice, 0, ',', '.') }}</span>
                                @if($p->discount > 0)
                                    <span class="text-[9px] text-[#CD2828] font-black">OFF {{ $p->discount }}%</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="{{ $p->stock < 10 ? 'text-[#CD2828]' : 'text-gray-800' }} font-black">
                                {{ $p->stock }} UNIT
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <span class="px-3 py-1 rounded-lg text-[9px] font-black {{ $p->status == 'active' ? 'bg-green-100 text-green-600 border border-green-200' : 'bg-yellow-100 text-yellow-600 border border-yellow-200' }}">
                                {{ strtoupper($p->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <a href="{{ route('staff.products.show', $p) }}" class="bg-black text-white px-4 py-2 rounded-xl text-[9px] font-black hover:bg-[#CD2828] transition-all">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center">
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.5em]">No products registered</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-8 py-6 border-t-2 border-gray-50 bg-gray-50/50">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
@endsection