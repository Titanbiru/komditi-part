@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold mb-8 text-gray-800">Report-Sales</h1>

<div class="py-4">
    @include('admin.reports._filter')
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <div class="border-2 border-black rounded-xl p-4 bg-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        <h4 class="font-bold text-xs uppercase mb-1 text-gray-500">Total Products Sold</h4>
        <p class="text-3xl font-bold text-[#CD2828]">{{ $totalProductsSold }} <span class="text-black text-sm">type</span></p>
    </div>
    <div class="border-2 border-black rounded-xl p-4 bg-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        <h4 class="font-bold text-xs uppercase mb-1 text-gray-500">Total Quantity Sold</h4>
        <p class="text-3xl font-bold text-[#CD2828]">{{ $totalQuantitySold }} <span class="text-black text-sm">unit</span></p>
    </div>
    <div class="border-2 border-black rounded-xl p-4 bg-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        <h4 class="font-bold text-xs uppercase mb-1 text-gray-500">Total Revenue</h4>
        <p class="text-2xl font-bold text-[#CD2828]">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
    <div class="border-2 border-black rounded-xl p-4 bg-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        <h4 class="font-bold text-xs uppercase mb-1 text-gray-500">Best Seller</h4>
        <p class="text-xl font-bold text-[#CD2828] truncate" title="{{ $topProduct }}">{{ $topProduct }}</p>
    </div>
</div>

<div class="bg-white border-2 border-black rounded-xl overflow-hidden shadow-sm">
    <table class="min-w-full">
        <thead class="bg-[#C4C4C4] border-b-2 border-black text-xs font-bold uppercase">
            <tr>
                <th class="p-4 text-left border-r border-black">Product Name</th>
                <th class="p-4 text-center border-r border-black">Quantity Sold</th>
                <th class="p-4 text-center border-r border-black">Unit Price</th>
                <th class="p-4 text-center">Total Sales</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($orders as $order)
                @foreach($order->items as $item)
                <tr class="text-xs hover:bg-gray-50 transition-colors">
                    <td class="p-4 font-bold uppercase leading-tight text-gray-800">
                        {{ $item->product_name_snapshot }}
                    </td>
                    <td class="p-4 text-center font-medium">
                        {{ $item->quantity }} unit
                    </td>
                    <td class="p-4 text-center">
                        Rp {{ number_format($item->product_price_snapshot, 0, ',', '.') }}
                    </td>
                    <td class="p-4 text-center font-bold text-[#CD2828]">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $orders->links() }}
</div>

    <div class="flex flex-col items-center mt-10 no-print">
        @php
            $downloadRoute = str_replace(['sales', 'stocks', 'transactions'], ['sales.pdf', 'stocks.pdf', 'transactions.pdf'], Route::currentRouteName());
        @endphp
        @if(Route::currentRouteName() != 'admin.reports.index')
        <button type="button" onclick="downloadReport('{{ $downloadRoute }}')" class="bg-black text-white px-6 py-2 rounded-full font-black uppercase tracking-tighter shadow-[4px_4px_0px_0px_rgba(0,186,211,1)] hover:translate-y-1 hover:shadow-none transition-all">
            PDF
        </button>
        @endif
    </div>
</div>

<style>
    @media print {
        .no-print { display: none; }
        body { padding: 0; margin: 0; }
        .border-black { border-color: #000 !important; }
    }
</style>
@endsection