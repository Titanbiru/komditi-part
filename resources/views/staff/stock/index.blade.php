@extends('layouts.staff')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Manage Stock</h1>
    <div class="relative">
        <form action="{{ route('staff.stock.index') }}" method="GET">
            <input type="text" name="search" placeholder="search" value="{{ request('search') }}"
                class="border border-[#BABABA] rounded-full px-4 py-2 text-sm focus:outline-none focus:border-[#CD2828] w-80 shadow-sm">
        </form>
        <p class="text-[10px] text-gray-400 mt-1 text-center font-medium italic">*find by category using search</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="border-2 border-black rounded-2xl p-6 bg-white shadow-sm">
        <h3 class="text-sm font-bold mb-2 uppercase tracking-tight">Total Product</h3>
        <p class="text-4xl font-bold text-[#CD2828]">{{ $totalProducts }}</p>
    </div>
    <div class="border-2 border-black rounded-2xl p-6 bg-white shadow-sm">
        <h3 class="text-sm font-bold mb-2 uppercase tracking-tight">Safe Stock</h3>
        <p class="text-3xl font-bold text-[#CD2828]">{{ $safeStock }} <span class="text-black text-2xl font-bold">product</span></p>
    </div>
    <div class="border-2 border-black rounded-2xl p-6 bg-white shadow-sm">
        <h3 class="text-sm font-bold mb-2 uppercase tracking-tight">Empty Stocks</h3>
        <p class="text-4xl font-bold text-[#CD2828]">{{ $emptyStock }} <span class="text-black text-2xl font-bold">product</span></p>
    </div>
    <div class="border-2 border-black rounded-2xl p-6 bg-white shadow-sm">
        <h3 class="text-sm font-bold mb-2 uppercase tracking-tight">Stock Running Low</h3>
        <p class="text-3xl font-bold text-[#CD2828]">{{ $runningLow }} <span class="text-black text-2xl font-bold">product</span></p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-md border border-[#BABABA] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-[#C4C4C4]">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-bold text-black border-r border-white">Product Name</th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-black border-r border-white">SKU</th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-black border-r border-white text-center">Current Stocks</th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-black border-r border-white text-center">Minimum Stock</th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-black border-r border-white text-center">status</th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-black text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#BABABA]">
                @forelse($products as $p)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-xs font-bold text-gray-800 uppercase leading-tight">{{ $p->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 font-medium">{{ $p->sku }}</td>
                    <td class="px-6 py-4 text-sm text-center font-bold">{{ $p->stock }}</td>
                    <td class="px-6 py-4 text-sm text-center font-bold">10</td> {{-- Dummy sesuai gambar --}}
                    <td class="px-6 py-4 text-sm text-center">
                        @if($p->stock == 0)
                            <span class="text-red-600 font-bold">Empty</span>
                        @elseif($p->stock < 10)
                            <span class="text-yellow-500 font-bold">Nonactive/Need restrock</span>
                        @else
                            <span class="text-green-500 font-bold">Active</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-center">
                        <a href="{{ route('staff.stock.edit', $p->id) }}" class="text-[#1BCFD5] font-bold hover:underline">Edit</a>
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('staff.stock.history', $p->id) }}" class="text-gray-500 font-bold hover:underline">History</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="p-10 text-center italic text-gray-400">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-[#BABABA] bg-gray-50 flex items-center justify-between">
        {{ $products->links('pagination::tailwind') }}
    </div>
</div>
@endsection