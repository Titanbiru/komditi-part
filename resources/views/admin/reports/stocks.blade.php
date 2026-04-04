@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold mb-8 text-gray-800">Report-Stocks</h1>

<div class="py-4">
    @include('admin.reports._filter')
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <div class="border-2 border-black rounded-xl p-4 bg-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        <h4 class="font-bold text-xs uppercase mb-1 text-gray-500">Total Products</h4>
        <p class="text-3xl font-bold text-[#CD2828]">{{ $totalProducts }}</p>
    </div>
    <div class="border-2 border-black rounded-xl p-4 bg-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        <h4 class="font-bold text-xs uppercase mb-1 text-gray-500">Stock In</h4>
        <p class="text-3xl font-bold text-[#CD2828]">{{ $stockIn }}</p>
    </div>
    <div class="border-2 border-black rounded-xl p-4 bg-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        <h4 class="font-bold text-xs uppercase mb-1 text-gray-500">Stock Out</h4>
        <p class="text-3xl font-bold text-[#CD2828]">{{ $stockOut }}</p>
    </div>
    <div class="border-2 border-black rounded-xl p-4 bg-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        <h4 class="font-bold text-xs uppercase mb-1 text-gray-500">Out of Stock</h4>
        <p class="text-3xl font-bold text-[#CD2828]">{{ $outOfStockProducts }}</p>
    </div>
</div>

<div class="bg-white border-2 border-black rounded-xl overflow-hidden shadow-sm">
    <table class="min-w-full">
        <thead class="bg-[#C4C4C4] border-b-2 border-black text-xs font-bold uppercase">
            <tr>
                <th class="p-4 text-left border-r border-white">Product Name</th>
                <th class="p-4 text-center border-r border-white">Type</th>
                <th class="p-4 text-center border-r border-white">Quantity</th>
                <th class="p-4 text-center">Date</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-xs">
            @foreach($stockHistory as $history)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="p-4 font-bold uppercase text-gray-800">{{ $history->product_name }}</td>
                <td class="p-4 text-center">
                    <span class="font-bold {{ $history->change_type == 'in' ? 'text-green-600' : 'text-red-600' }}">
                        {{ strtoupper($history->change_type) }}
                    </span>
                </td>
                <td class="p-4 text-center font-bold">{{ $history->quantity }} unit</td>
                <td class="p-4 text-center text-gray-500">
                    {{ \Carbon\Carbon::parse($history->created_at)->format('d/m/Y H:i') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $stockHistory->links() }}
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
@endsection