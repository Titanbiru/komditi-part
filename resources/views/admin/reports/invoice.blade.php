<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }}</title>
    {{-- Kita panggil Tailwind langsung agar styling aman saat diprint --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Pengaturan Kertas Print */
        @media print {
            @page { size: A4 portrait; margin: 0; }
            body { 
                background: white !important; 
                padding: 1cm; 
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact; 
            }
            .no-print { display: none !important; }
            /* Matikan shadow ala brutalism saat diprint biar hemat tinta & rapi */
            .shadow-brutal { box-shadow: none !important; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8 font-sans text-black">

    {{-- TOMBOL KEMBALI & PRINT (Sembunyi saat diprint) --}}
    <div class="max-w-3xl mx-auto flex justify-between items-center mb-8 no-print">
        <button onclick="window.close()" class="text-sm font-bold flex items-center gap-2 hover:underline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg> Close Tab
        </button>
        <button onclick="window.print()" class="bg-black text-white px-6 py-2 rounded-full font-black uppercase text-xs shadow-[4px_4px_0px_0px_rgba(205,40,40,1)] hover:translate-y-1 transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Print Invoice
        </button>
    </div>

    {{-- KERTAS INVOICE UTAMA --}}
    <div class="max-w-3xl mx-auto bg-white border-2 border-black p-10 shadow-[10px_10px_0px_0px_rgba(0,0,0,1)] shadow-brutal">
        
        <div class="flex justify-between items-start mb-10">
            <div>
                <h1 class="text-5xl font-black tracking-tighter uppercase leading-none">Invoice</h1>
                <p class="font-bold text-[#CD2828] mt-2 tracking-widest">NO: {{ $order->order_number }}</p>
            </div>
            <div class="text-right">
                <h2 class="text-2xl font-black uppercase italic tracking-tight">Komditi Part</h2>
                <p class="text-[10px] font-bold text-gray-400">OFFICIAL TRANSACTION RECEIPT</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-10 mb-10 pb-8 border-b-2 border-black">
            <div>
                <h4 class="text-[10px] font-black uppercase text-gray-400 mb-3 tracking-widest">Billed To:</h4>
                <p class="font-black text-lg uppercase leading-tight">{{ $order->shipping_snapshot['recipient_name'] ?? $order->user->name ?? 'Guest' }}</p>
                <p class="text-xs font-bold text-gray-600 mt-2 leading-relaxed">
                    {{ $order->shipping_snapshot['address'] ?? $order->shipping_address ?? 'No Address Provided' }}<br>
                    {{ $order->shipping_snapshot['city'] ?? '' }} {{ $order->shipping_snapshot['province'] ?? '' }}<br>
                    {{ $order->shipping_snapshot['postal_code'] ?? '' }}
                </p>
                <p class="text-xs font-black mt-2 text-gray-800">{{ $order->shipping_snapshot['phone'] ?? $order->shipping_phone ?? '' }}</p>
            </div>
            <div class="text-right flex flex-col justify-end">
                <div class="mb-4">
                    <h4 class="text-[10px] font-black uppercase text-gray-400 mb-1 tracking-widest">Date:</h4>
                    <p class="font-black text-sm uppercase">{{ $order->created_at->format('d M Y') }}</p>
                </div>
                <div>
                    <h4 class="text-[10px] font-black uppercase text-gray-400 mb-1 tracking-widest">Payment Status:</h4>
                    <span class="inline-block bg-black text-white px-3 py-1 text-[10px] font-bold uppercase tracking-widest">
                        {{ $order->payment_status }}
                    </span>
                </div>
            </div>
        </div>

        <table class="w-full mb-8">
            <thead>
                <tr class="border-b-2 border-black text-[10px] font-black uppercase tracking-widest text-gray-500">
                    <th class="py-4 text-left">Item Description</th>
                    <th class="py-4 text-center">Qty</th>
                    <th class="py-4 text-right">Unit Price</th>
                    <th class="py-4 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($order->items as $item)
                @php
                    // Pastikan harga aman dan tidak error
                    $hargaSatuan = $item->product_price_snapshot ?? $item->price ?? 0;
                    $qty = $item->quantity ?? 1;
                    $subtotal = $hargaSatuan * $qty; // Hitung manual disini biar nggak Rp 0
                @endphp
                <tr class="text-sm font-bold">
                    <td class="py-5 uppercase tracking-tighter">{{ $item->product_name_snapshot ?? $item->product_name ?? '-' }}</td>
                    <td class="py-5 text-center">{{ $qty }}</td>
                    <td class="py-5 text-right">Rp {{ number_format($hargaSatuan, 0, ',', '.') }}</td>
                    <td class="py-5 text-right text-[#CD2828] font-black">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-end border-t-2 border-black pt-6">
            <div class="w-72">
                <div class="flex justify-between py-1 text-xs font-bold">
                    <span class="text-gray-400 tracking-widest">SUBTOTAL</span>
                    <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-1 text-xs font-bold mt-1">
                    <span class="text-gray-400 tracking-widest">SHIPPING</span>
                    <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                
                @if($order->admin_fee > 0)
                <div class="flex justify-between py-1 text-xs font-bold mt-1">
                    <span class="text-gray-400 tracking-widest">ADMIN FEE</span>
                    <span>Rp {{ number_format($order->admin_fee, 0, ',', '.') }}</span>
                </div>
                @endif
                
                @if($order->unique_code > 0)
                <div class="flex justify-between py-1 text-xs font-bold mt-1">
                    <span class="text-gray-400 tracking-widest">UNIQUE CODE</span>
                    <span>+{{ $order->unique_code }}</span>
                </div>
                @endif

                <div class="flex justify-between mt-4 py-4 border-t-2 border-black bg-gray-50 px-2">
                    <span class="text-sm font-black uppercase tracking-widest">Grand Total</span>
                    <span class="text-xl font-black text-[#CD2828] tracking-tighter">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center">
            <p class="text-[9px] font-black uppercase tracking-[0.3em] text-gray-300">Thank you for shopping at Komditi Part</p>
        </div>
    </div>

    {{-- Script untuk auto-print (Opsional, kalau mau pas tab dibuka langsung muncul pop-up print) --}}
    {{-- <script>window.onload = function() { window.print(); }</script> --}}
</body>
</html>