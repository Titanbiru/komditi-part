@extends('layouts.staff')

@section('content')
<div class="max-w-6xl mx-auto pb-20">
    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-10 no-print px-2">
        <div class="flex items-center gap-6">
            <a href="{{ route('staff.reports.transactions') }}" class="bg-[#F9F9F9] p-3 rounded-2xl hover:bg-[#202020] hover:text-white transition-all text-[#BABABA]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-black uppercase tracking-tighter text-[#202020]">Transaction Detail</h1>
                <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Order Log: #{{ $order->order_number }}</p>
            </div>
        </div>
        
        <a href="{{ route('admin.reports.invoice', $order->id) }}" target="_blank" 
            class="bg-[#202020] text-white px-8 py-3 rounded-2xl font-black uppercase tracking-widest hover:bg-[#CD2828] transition-all flex items-center gap-3 text-[10px] shadow-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Print Invoice
        </a>
    </div>

    {{-- KOTAK INFO ATAS (Minimalist Grid) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
        {{-- 1. Info Pengiriman --}}
        <div class="border border-[#BABABA]/20 rounded-[2rem] p-6 bg-white shadow-sm flex flex-col justify-between">
            <div>
                <h4 class="text-[8px] font-black uppercase text-[#BABABA] mb-3 tracking-[0.2em]">Customer & Shipping</h4>
                <p class="text-sm font-black text-[#202020] uppercase mb-1 leading-tight">{{ $order->shipping_snapshot['recipient_name'] ?? $order->shipping_name ?? $order->user->name ?? 'GUEST' }}</p>
                <p class="text-[10px] text-[#BABABA] font-bold">{{ $order->shipping_phone ?? $order->user->phone ?? '-' }}</p>
            </div>
            <p class="text-[10px] font-bold text-gray-500 mt-4 leading-relaxed uppercase">{{ $order->shipping_address }}</p>
        </div>

        {{-- 2. Status & Resi --}}
        <div class="border border-[#BABABA]/20 rounded-[2rem] p-6 bg-white shadow-sm flex flex-col items-center text-center justify-center">
            <h4 class="text-[8px] font-black uppercase text-[#BABABA] mb-4 tracking-[0.2em]">Order Status</h4>
            <div class="flex flex-col gap-2 w-full">
                <span class="px-4 py-1.5 rounded-xl font-black uppercase text-[9px] tracking-widest {{ $order->payment_status == 'paid' ? 'bg-green-50 text-[#1BCFD5]' : 'bg-red-50 text-[#CD2828]' }}">
                    PAYMENT: {{ $order->payment_status }}
                </span>
                <span class="px-4 py-1.5 rounded-xl font-black uppercase text-[9px] tracking-widest bg-[#F9F9F9] text-[#202020]">
                    LOGISTIC: {{ $order->shipment_status }}
                </span>
            </div>
            @if($order->resi_number)
                <div class="mt-4 pt-4 border-t border-[#F9F9F9] w-full">
                    <p class="text-[8px] font-black text-[#BABABA] uppercase mb-1">AWB J&T</p>
                    <p class="font-black text-xs text-[#202020] tracking-widest">{{ $order->resi_number }}</p>
                </div>
            @endif
        </div>

        {{-- 3. Grand Total --}}
        <div class="border border-[#BABABA]/20 rounded-[2rem] p-6 bg-white shadow-sm flex flex-col items-center text-center justify-center border-t-4 border-t-[#CD2828]">
            <h4 class="text-[8px] font-black uppercase text-[#BABABA] mb-2 tracking-[0.2em]">Final Amount</h4>
            <p class="text-2xl font-black text-[#CD2828] tracking-tighter">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</p>
            <p class="text-[9px] font-black text-[#BABABA] uppercase mt-3 tracking-widest">{{ $order->payment_method ?? 'CASH/MANUAL' }}</p>
        </div>

        {{-- 4. BUKTI PENERIMAAN --}}
        <div class="border border-[#BABABA]/20 rounded-[2rem] p-6 bg-white shadow-sm flex flex-col items-center text-center justify-center">
            <h4 class="text-[8px] font-black uppercase text-[#BABABA] mb-3 tracking-[0.2em]">Receipt Proof</h4>
            @if($order->receipt_image)
                <a href="{{ Storage::url($order->receipt_image) }}" target="_blank" class="block w-full h-20 bg-[#F9F9F9] rounded-2xl overflow-hidden border border-[#BABABA]/10 hover:opacity-80 transition-opacity">
                    <img src="{{ Storage::url($order->receipt_image) }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all">
                </a>
            @else
                <div class="w-full h-20 bg-[#F9F9F9] rounded-2xl border-2 border-dashed border-[#BABABA]/10 flex items-center justify-center">
                    <span class="text-[8px] font-black uppercase tracking-widest text-[#BABABA]">No Proof</span>
                </div>
            @endif
        </div>
    </div>

    {{-- TABEL PRODUK (Mirip Manage Product) --}}
    <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] overflow-hidden shadow-sm mb-10">
        <div class="bg-[#F3F3F3] border-b-2 border-white p-6 flex justify-between items-center text-[#202020]">
            <h3 class="font-black uppercase text-[10px] tracking-widest">Purchased Items</h3>
            <span class="text-[9px] font-black bg-white px-4 py-1 rounded-xl shadow-sm border border-[#BABABA]/10 uppercase">{{ $order->items->count() }} Products</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px]">
                <thead class="bg-[#F9F9F9] border-b border-[#BABABA]/10 text-[9px] font-black uppercase text-[#BABABA] tracking-widest">
                    <tr>
                        <th class="p-6 text-left border-r border-[#BABABA]/5">Item Identity</th>
                        <th class="p-6 text-center border-r border-[#BABABA]/5">Unit Price</th>
                        <th class="p-6 text-center border-r border-[#BABABA]/5">Qty</th>
                        <th class="p-6 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#BABABA]/10 font-bold uppercase text-[11px] text-[#202020]">
                    @foreach($order->items as $item)
                    <tr class="hover:bg-[#F9F9F9] transition-colors">
                        <td class="p-6 border-r border-[#BABABA]/5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-[#F9F9F9] rounded-xl overflow-hidden flex-shrink-0 border border-[#BABABA]/10">
                                    @php $gambarProduk = $item->product?->images->first()?->image_path; @endphp
                                    @if($gambarProduk)
                                        <img src="{{ Storage::url($gambarProduk) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-[#BABABA]">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2"/></svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-black text-[#202020] tracking-tight">{{ $item->product_name_snapshot ?? $item->product_name ?? 'REMOVED ITEM' }}</p>
                                    <p class="text-[8px] text-[#BABABA] tracking-widest mt-1">SKU: {{ $item->product->sku ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-6 text-center border-r border-[#BABABA]/5">
                            @php
                                $hargaBayar = $item->product_price_snapshot ?? $item->price ?? 0;
                                $hargaAsliMaster = $item->product ? $item->product->price : $hargaBayar;
                            @endphp
                            <p class="font-black text-[#202020]">Rp{{ number_format($hargaBayar, 0, ',', '.') }}</p>
                            @if($hargaAsliMaster > $hargaBayar)
                                <p class="text-[9px] text-[#BABABA] line-through">Rp{{ number_format($hargaAsliMaster, 0, ',', '.') }}</p>
                            @endif
                        </td>
                        <td class="p-6 text-center border-r border-[#BABABA]/5 font-black text-[#202020]">
                            {{ $item->quantity }} <span class="text-[9px] text-[#BABABA]">PCS</span>
                        </td>
                        <td class="p-6 text-right text-[#1BCFD5] font-black">
                            Rp{{ number_format(($item->product_price_snapshot ?? $item->price ?? 0) * $item->quantity, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                
                {{-- SUMMARY AREA --}}
                <tfoot class="bg-[#F9F9F9]/50 border-t border-[#BABABA]/20 text-[9px] font-black uppercase tracking-widest text-[#BABABA]">
                    <tr>
                        <td colspan="3" class="px-8 py-4 text-right border-r border-[#BABABA]/10">Merchandise Subtotal</td>
                        <td class="px-8 py-4 text-right text-[#202020]">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="px-8 py-4 text-right border-r border-[#BABABA]/10">Shipment (J&T)</td>
                        <td class="px-8 py-4 text-right text-[#202020]">Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                    </tr>
                    @if($order->admin_fee > 0)
                    <tr>
                        <td colspan="3" class="px-8 py-4 text-right border-r border-[#BABABA]/10">Platform Fee</td>
                        <td class="px-8 py-4 text-right text-[#202020]">Rp{{ number_format($order->admin_fee, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    @if($order->unique_code > 0)
                    <tr>
                        <td colspan="3" class="px-8 py-4 text-right border-r border-[#BABABA]/10">Unique Verification Code</td>
                        <td class="px-8 py-4 text-right text-[#1BCFD5]">+{{ $order->unique_code }}</td>
                    </tr>
                    @endif

                    @php
                        $totalHargaNormal = 0;
                        foreach($order->items as $item) {
                            $hargaAsli = $item->product ? $item->product->price : ($item->product_price_snapshot ?? 0);
                            $totalHargaNormal += $hargaAsli * $item->quantity;
                        }
                        $totalHemat = $totalHargaNormal - $order->total_price;
                    @endphp
                    @if($totalHemat > 0)
                    <tr class="text-[#CD2828] bg-red-50/30">
                        <td colspan="3" class="px-8 py-4 text-right border-r border-[#BABABA]/10">Total Savings</td>
                        <td class="px-8 py-4 text-right">- Rp{{ number_format($totalHemat, 0, ',', '.') }}</td>
                    </tr>
                    @endif

                    <tr class="bg-[#202020] text-white">
                        <td colspan="3" class="px-8 py-6 text-right text-[11px] tracking-[0.2em] border-r border-white/10">Grand Total Amount</td>
                        <td class="px-8 py-6 text-right text-2xl text-[#1BCFD5] font-black tracking-tighter">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        .bg-admin-sidebar, nav, button, .no-print, a.bg-black, a[href*="invoice"] {
            display: none !important;
        }
        body { background: white !important; padding: 0; }
        .rounded-\[2rem\], .rounded-\[2\.5rem\] { border-radius: 0 !important; }
        .shadow-sm, .shadow-lg { box-shadow: none !important; }
        .border { border: 1px solid #000 !important; }
    }
</style>
@endsection