@extends('layouts.staff')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Inventory & Stock Report</h1>
</div>

{{-- NAV --}}
<div class="bg-white border-2 border-black rounded-3xl p-6 mb-10 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
    <a href="{{ route('staff.reports.index') }}" class="bg-gray-200 p-2 rounded-full hover:bg-gray-300 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <div class="flex gap-2">
        @php
                $menus = [
                    ['name' => 'Sales', 'route' => 'staff.reports.sales'],
                    ['name' => 'Stock', 'route' => 'staff.reports.stocks'],
                    ['name' => 'Transaction', 'route' => 'staff.reports.transactions'],
                ];
            @endphp
        @foreach($menus as $menu)
            <a href="{{ route($menu['route']) }}" class="px-6 py-1 rounded-full border-2 border-black text-sm font-bold {{ Route::currentRouteName() == $menu['route'] ? 'bg-[#CD2828] text-white border-[#CD2828]' : 'bg-white' }}">
                {{ $menu['name'] }}
            </a>
        @endforeach
    </div>
    <form class="flex gap-2">
        <input type="date" name="start" value="{{ request('start') }}" class="border-2 border-black rounded-lg px-2 text-sm">
        <input type="date" name="end" value="{{ request('end') }}" class="border-2 border-black rounded-lg px-2 text-sm">
        <button type="submit" class="bg-[#1BCFD5] text-white px-4 py-1 rounded-full font-bold shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">Filter</button>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    <div class="bg-white border-2 border-black p-6 rounded-2xl text-center shadow-sm">
        <h4 class="text-gray-500 font-bold text-xs uppercase">Total Products</h4>
        <p class="text-2xl font-black">{{ $totalProducts }}</p>
    </div>
    <div class="bg-white border-2 border-black p-6 rounded-2xl text-center shadow-sm">
        <h4 class="text-gray-500 font-bold text-xs uppercase">In Stock</h4>
        <p class="text-2xl font-black text-green-600">{{ $stockIn }}</p>
    </div>
    <div class="bg-white border-2 border-black p-6 rounded-2xl text-center shadow-sm">
        <h4 class="text-gray-500 font-bold text-xs uppercase">Out of Stock</h4>
        <p class="text-2xl font-black text-red-600">{{ $stockOut }}</p>
    </div>
    <div class="bg-[#CD2828] text-white border-2 border-black p-6 rounded-2xl text-center shadow-sm">
        <h4 class="font-bold text-xs uppercase opacity-80">Urgent Restock</h4>
        <p class="text-2xl font-black">{{ $outOfStockProducts }} Items</p>
    </div>
</div>

<div class="bg-white border-2 border-black rounded-2xl overflow-hidden shadow-sm">
    <div class="p-4 bg-gray-50 border-b-2 border-black font-black uppercase text-sm">Stock Movement History</div>
    <table class="w-full text-left">
        <thead class="bg-gray-100 border-b border-black">
            <tr>
                <th class="p-4 font-black text-xs uppercase">Product Name</th>
                <th class="p-4 font-black text-xs uppercase">Type</th>
                <th class="p-4 font-black text-xs uppercase">Amount</th>
                <th class="p-4 font-black text-xs uppercase">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stockHistory as $history)
            <tr class="border-b border-gray-100">
                <td class="p-4 font-bold">{{ $history->product_name }}</td>
                <td class="p-4">
                    <span class="px-2 py-1 rounded text-[10px] font-black uppercase {{ $history->change_type == 'in' ? 'bg-blue-100 text-blue-600' : 'bg-orange-100 text-orange-600' }}">
                        {{ $history->change_type }}
                    </span>
                </td>
                <td class="p-4 font-black">{{ $history->quantity }}</td>
                <td class="p-4 text-gray-500 text-sm">{{ $history->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $stockHistory->links() }}</div>
@endsection