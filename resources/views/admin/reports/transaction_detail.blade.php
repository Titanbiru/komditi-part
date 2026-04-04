@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto pb-20">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.reports.transactions') }}" class="bg-white border-2 border-black p-2 rounded-xl shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-y-1 hover:shadow-none transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-black uppercase tracking-tighter">Transaction Detail</h1>
            <p class="text-gray-500 font-bold">Order ID: #{{ $order->order_number }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="border-2 border-black rounded-2xl p-6 bg-white shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">
            <h4 class="text-xs font-black uppercase text-gray-400 mb-3 tracking-widest">Customer Info</h4>
            <p class="text-xl font-bold mb-1">{{ $order->user->name ?? 'Guest Customer' }}</p>
            <p class="text-sm text-gray-500 font-medium">{{ $order->user->email ?? '-' }}</p>
            <p class="text-sm text-gray-500 font-medium">{{ $order->user->phone ?? '-' }}</p>
        </div>

        <div class="border-2 border-black rounded-2xl p-6 bg-white shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] flex flex-col justify-center items-center">
            <h4 class="text-xs font-black uppercase text-gray-400 mb-3 tracking-widest">Payment Status</h4>
            <span class="px-6 py-2 rounded-full border-2 border-black font-black uppercase text-sm mb-3 
                {{ $order->payment_status == 'paid' ? 'bg-[#1BCFD5] text-white' : 'bg-yellow-400 text-black' }}">
                {{ $order->payment_status }}
            </span>
            <p class="text-xs font-bold text-gray-400 uppercase">Ordered At:</p>
            <p class="font-bold text-sm">{{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</p>
        </div>

        <div class="border-2 border-black rounded-2xl p-6 bg-[#CD2828] text-white shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] flex flex-col justify-center">
            <h4 class="text-xs font-black uppercase opacity-80 mb-1 tracking-widest text-center">Grand Total</h4>
            <p class="text-3xl font-black text-center">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-white border-2 border-black rounded-2xl overflow-hidden shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] mb-10">
        <div class="bg-[#C4C4C4] border-b-2 border-black p-4">
            <h3 class="font-black uppercase tracking-tighter">Purchased Items</h3>
        </div>
        <table class="w-full">
            <thead class="bg-gray-50 border-b-2 border-black text-xs font-black uppercase text-gray-600">
                <tr>
                    <th class="p-4 text-left border-r-2 border-black">Product Name</th>
                    <th class="p-4 text-center border-r-2 border-black">Price</th>
                    <th class="p-4 text-center border-r-2 border-black">Qty</th>
                    <th class="p-4 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y-2 divide-gray-100 font-bold">
                @foreach($order->items as $item)
                <tr class="text-sm">
                    <td class="p-4 border-r-2 border-black">
                        <div class="flex flex-col">
                            <span class="uppercase tracking-tight">{{ $item->product_name_snapshot }}</span>
                            <span class="text-[10px] text-gray-400 italic">SKU: {{ $item->product->sku ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="p-4 text-center border-r-2 border-black">
                        Rp {{ number_format($item->product_price_snapshot, 0, ',', '.') }}
                    </td>
                    <td class="p-4 text-center border-r-2 border-black">
                        {{ $item->quantity }} unit
                    </td>
                    <td class="p-4 text-right text-[#CD2828]">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-100 border-t-2 border-black font-black">
                <tr>
                    <td colspan="3" class="p-4 text-right uppercase text-xs border-r-2 border-black">Subtotal Amount</td>
                    <td class="p-4 text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
                {{-- Jika ada ongkir atau biaya tambahan --}}
                @if($order->shipping_cost > 0)
                <tr>
                    <td colspan="3" class="p-4 text-right uppercase text-xs border-r-2 border-black">Shipping Cost</td>
                    <td class="p-4 text-right">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr class="bg-[#1A1A1A] text-white">
                    <td colspan="3" class="p-4 text-right uppercase tracking-widest text-sm border-r-2 border-gray-700">Final Total</td>
                    <td class="p-4 text-right text-xl text-[#1BCFD5]">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="flex justify-center gap-4">
        <button onclick="window.print()" class="bg-white border-2 border-black px-8 py-3 rounded-xl font-black uppercase shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-y-1 hover:shadow-none transition-all">
            Print Invoice
        </button>
        @if($order->payment_status == 'paid')
        <div class="bg-[#1BCFD5] text-white px-8 py-3 rounded-xl font-black uppercase border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
            Transaction Completed
        </div>
        @endif
    </div>
</div>

<style>
    @media print {
        .bg-admin-sidebar, nav, button, .no-print {
            display: none !important;
        }
        body {
            background: white !important;
            padding: 0;
        }
        .shadow-\[6px_6px_0px_0px_rgba\(0\,0\,0\,1\)\] {
            box-shadow: none !important;
            border: 1px solid black !important;
        }
    }
</style>
@endsection