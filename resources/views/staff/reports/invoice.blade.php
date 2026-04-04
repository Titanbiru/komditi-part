@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto my-10 no-print-margin">
    <div class="flex justify-between items-center mb-8 no-print">
        <a href="{{ route('admin.reports.transactions.show', $order->id) }}" class="text-sm font-bold flex items-center gap-2 hover:underline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="3" stroke="currentColor"/></svg> Back
        </a>
        <button onclick="window.print()" class="bg-black text-white px-6 py-2 rounded-full font-black uppercase text-xs shadow-[4px_4px_0px_0px_rgba(205,40,40,1)] hover:translate-y-1 transition-all">
            Print Invoice
        </button>
    </div>

    <div class="bg-white border-2 border-black p-10 shadow-[10px_10px_0px_0px_rgba(0,0,0,1)]">
        <div class="flex justify-between items-start mb-10">
            <div>
                <h1 class="text-5xl font-black tracking-tighter uppercase leading-none">Invoice</h1>
                <p class="font-bold text-[#CD2828] mt-2">NO: {{ $order->order_number }}</p>
            </div>
            <div class="text-right">
                <h2 class="text-2xl font-black uppercase italic">Komditi Part</h2>
                <p class="text-[10px] font-bold text-gray-400">OFFICIAL TRANSACTION RECEIPT</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-10 mb-10 pb-8 border-b-2 border-black">
            <div>
                <h4 class="text-[10px] font-black uppercase text-gray-400 mb-3 tracking-widest">Billed To:</h4>
                {{-- Mengambil data dari JSON snapshot --}}
                <p class="font-black text-lg uppercase">{{ $order->shipping_snapshot['recipient_name'] ?? $order->user->name }}</p>
                <p class="text-xs font-bold text-gray-600 mt-1">
                    {{ $order->shipping_snapshot['address'] ?? 'No Address Provided' }}<br>
                    {{ $order->shipping_snapshot['city'] ?? '' }}, {{ $order->shipping_snapshot['province'] ?? '' }}<br>
                    {{ $order->shipping_snapshot['postal_code'] ?? '' }}
                </p>
                <p class="text-xs font-black mt-2 text-gray-800">{{ $order->shipping_snapshot['phone'] ?? '' }}</p>
            </div>
            <div class="text-right flex flex-col justify-end">
                <div class="mb-4">
                    <h4 class="text-[10px] font-black uppercase text-gray-400 mb-1 tracking-widest">Date:</h4>
                    <p class="font-black text-sm uppercase">{{ $order->created_at->format('d M Y') }}</p>
                </div>
                <div>
                    <h4 class="text-[10px] font-black uppercase text-gray-400 mb-1 tracking-widest">Payment Status:</h4>
                    <span class="inline-block bg-black text-white px-3 py-1 text-[10px] font-bold uppercase">
                        {{ $order->payment_status }}
                    </span>
                </div>
            </div>
        </div>

        <table class="w-full mb-8">
            <thead>
                <tr class="border-b-2 border-black text-[10px] font-black uppercase">
                    <th class="py-4 text-left">Item Description</th>
                    <th class="py-4 text-center">Qty</th>
                    <th class="py-4 text-right">Unit Price</th>
                    <th class="py-4 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($order->items as $item)
                <tr class="text-sm font-bold">
                    <td class="py-5 uppercase tracking-tighter">{{ $item->product_name_snapshot }}</td>
                    <td class="py-5 text-center">{{ $item->quantity }}</td>
                    <td class="py-5 text-right">Rp {{ number_format($item->product_price_snapshot, 0, ',', '.') }}</td>
                    <td class="py-5 text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-end border-t-2 border-black pt-6">
            <div class="w-72">
                <div class="flex justify-between py-1 text-xs font-bold">
                    <span class="text-gray-400">SUBTOTAL</span>
                    <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-1 text-xs font-bold">
                    <span class="text-gray-400">SHIPPING COST</span>
                    <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between mt-4 py-4 border-t-2 border-black bg-gray-50 px-2">
                    <span class="text-sm font-black uppercase">Grand Total</span>
                    <span class="text-xl font-black text-[#CD2828]">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center">
            <p class="text-[9px] font-black uppercase tracking-[0.3em] text-gray-300">Thank you for shopping at Komditi Part</p>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; padding: 0; }
        .no-print-margin { margin: 0 !important; max-width: 100% !important; }
        .shadow-\[10px_10px_0px_0px_rgba\(0\,0\,0\,1\)\] { box-shadow: none !important; }
    }
</style>
@endsection