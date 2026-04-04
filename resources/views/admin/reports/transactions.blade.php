@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold mb-8 text-gray-800">Report-Transaction</h1>

<div class="py-4">
    @include('admin.reports._filter')
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <div class="border-2 border-black rounded-xl p-4 bg-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        <h4 class="font-bold text-xs uppercase mb-1 text-gray-500">Total Transaction</h4>
        <p class="text-3xl font-bold text-[#CD2828]">{{ $total }}</p>
    </div>
    <div class="border-2 border-black rounded-xl p-4 bg-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        <h4 class="font-bold text-xs uppercase mb-1 text-gray-500">Pending</h4>
        <p class="text-3xl font-bold text-[#CD2828]">{{ $pending }}</p>
    </div>
    <div class="border-2 border-black rounded-xl p-4 bg-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        <h4 class="font-bold text-xs uppercase mb-1 text-gray-500">Paid</h4>
        <p class="text-3xl font-bold text-[#CD2828]">{{ $paid }}</p>
    </div>
    <div class="border-2 border-black rounded-xl p-4 bg-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        <h4 class="font-bold text-xs uppercase mb-1 text-gray-500">Total Value</h4>
        <p class="text-2xl font-bold text-[#CD2828]">Rp {{ number_format($totalValue, 0, ',', '.') }}</p>
    </div>
</div>

<div class="bg-white border-2 border-[#BABABA] rounded-xl overflow-hidden shadow-sm">
    <table class="min-w-full">
        <thead class="bg-[#C4C4C4] border-b-2 border-black text-xs font-bold uppercase">
            <tr>
                <th class="p-4 text-left border-r border-white">Order id</th>
                <th class="p-4 text-center border-r border-white">Date</th>
                <th class="p-4 text-left border-r border-white">Customer</th>
                <th class="p-4 text-center border-r border-white">Payment Status</th>
                <th class="p-4 text-center">Grand Total</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-xs">
            @foreach($transaction as $t)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="p-4 font-bold text-gray-800">{{ $t->order_number }}</td>
                <td class="p-4 text-center text-gray-500">{{ $t->created_at->format('d/m/Y') }}</td>
                <td class="p-4 font-medium">{{ $t->user->name ?? 'Guest' }}</td>
                <td class="p-4 text-center font-bold">
                    @if($t->payment_status == 'paid')
                        <span class="text-green-500 uppercase">Paid</span>
                    @else
                        <span class="text-yellow-500 uppercase">Pending</span>
                    @endif
                </td>
                <td class="p-4 text-center font-black">
                    Rp {{ number_format($t->grand_total, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $transaction->links() }}
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