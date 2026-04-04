@extends('layouts.staff')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Sales Report</h1>
</div>

{{-- AREA NAVIGASI --}}
<div class="bg-white border-2 border-black rounded-3xl p-6 mb-10 shadow-sm">
    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
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
</div>

{{-- CARDS --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    <div class="bg-white border-2 border-black p-6 rounded-2xl text-center">
        <h4 class="text-gray-500 font-bold text-xs uppercase">Total Revenue</h4>
        <p class="text-xl font-black">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white border-2 border-black p-6 rounded-2xl text-center">
        <h4 class="text-gray-500 font-bold text-xs uppercase">Quantity Sold</h4>
        <p class="text-xl font-black">{{ $totalQuantitySold }} Items</p>
    </div>
    <div class="bg-white border-2 border-black p-6 rounded-2xl text-center">
        <h4 class="text-gray-500 font-bold text-xs uppercase">Unique Products</h4>
        <p class="text-xl font-black">{{ $totalProductsSold }} Types</p>
    </div>
    <div class="bg-white text-[#CD2828] border-2 border-black p-6 rounded-2xl text-center">
        <h4 class="font-bold text-xs uppercase opacity-80">Best Seller</h4>
        <p class="text-lg font-black truncate">{{ $topProduct }}</p>
    </div>
</div>

{{-- TABLE --}}
<div class="bg-white border-2 border-black rounded-2xl overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-100 border-b-2 border-black">
            <tr>
                <th class="p-4 font-black uppercase text-xs">Order ID</th>
                <th class="p-4 font-black uppercase text-xs">Customer</th>
                <th class="p-4 font-black uppercase text-xs">Total</th>
                <th class="p-4 font-black uppercase text-xs">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr class="border-b border-gray-200 hover:bg-gray-50">
                <td class="p-4 font-bold">#{{ $order->id }}</td>
                <td class="p-4">{{ $order->user->name ?? 'Guest' }}</td>
                <td class="p-4 font-bold text-green-600">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                <td class="p-4 text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $orders->links() }}</div>
@endsection