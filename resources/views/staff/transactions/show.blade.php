<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $transaction->order_number }}</title>
    {{-- Panggil Tailwind langsung untuk halaman cetak --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CSS Khusus Mesin Print */
        @media print {
            @page { size: A4 portrait; margin: 0; }
            body { 
                background: white !important; 
                padding: 1cm; 
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact; 
            }
            .no-print { display: none !important; }
            /* Mematikan shadow saat diprint biar hemat tinta & rapi */
            .invoice-box { box-shadow: none !important; border: 2px solid black !important; }
            /* Memaksa warna tetap muncul saat diprint */
            .print-bg-gray { background-color: #f9fafb !important; }
            .print-text-red { color: #CD2828 !important; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8 font-sans text-black">

    {{-- TOMBOL KONTROL (Sembunyi pas nge-print) --}}
    <div class="max-w-3xl mx-auto flex justify-between items-center mb-8 no-print">
        <button onclick="window.close()" class="text-sm font-bold flex items-center gap-2 text-[#202020] hover:underline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg> Close Tab
        </button>
        <button onclick="window.print()" class="bg-black text-white px-6 py-2 rounded-full font-black uppercase text-xs shadow-[4px_4px_0px_0px_rgba(205,40,40,1)] hover:translate-y-1 transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Print Invoice
        </button>
    </div>

    {{-- KERTAS INVOICE UTAMA --}}
    <div class="max-w-3xl mx-auto bg-white border-2 border-black p-10 shadow-[10px_10px_0px_0px_rgba(0,0,0,1)] invoice-box">
        
        {{-- Header Invoice --}}
        <div class="flex justify-between items-start mb-10">
            <div>
                <h1 class="text-5xl font-black tracking-tighter uppercase leading-none">Invoice</h1>
                <p class="font-bold text-[#CD2828] mt-2 tracking-widest">NO: {{ $transaction->order_number }}</p>
            </div>
            <div class="text-right">
                <h2 class="text-2xl font-black uppercase italic tracking-tight">Komditi Part</h2>
                <p class="text-[10px] font-bold text-gray-400">OFFICIAL TRANSACTION RECEIPT</p>
            </div>
        </div>

        {{-- Info Pengiriman --}}
        <div class="grid grid-cols-2 gap-10 mb-10 pb-8 border-b-2 border-black">
            <div>
                <h4 class="text-[10px] font-black uppercase text-gray-400 mb-3 tracking-widest">Billed To:</h4>
                <p class="font-black text-lg uppercase">{{ $transaction->shipping_snapshot['recipient_name'] ?? $transaction->user->name }}</p>
                <p class="text-xs font-bold text-gray-600 mt-1 max-w-xs leading-relaxed">
                    {{ $transaction->shipping_address }}
                </p>
                <p class="text-xs font-black mt-2 text-gray-800">{{ $transaction->shipping_phone }}</p>
            </div>
            <div class="text-right flex flex-col justify-end">
                <div class="mb-4">
                    <h4 class="text-[10px] font-black uppercase text-gray-400 mb-1 tracking-widest">Date:</h4>
                    <p class="font-black text-sm uppercase">{{ $transaction->created_at->format('d M Y') }}</p>
                </div>
                <div class="mb-4">
                    <h4 class="text-[10px] font-black uppercase text-gray-400 mb-1 tracking-widest">Resi J&T:</h4>
                    <p class="font-black text-sm uppercase tracking-widest">{{ $transaction->resi_number ?? 'BELUM INPUT' }}</p>
                </div>
                <div>
                    <h4 class="text-[10px] font-black uppercase text-gray-400 mb-1 tracking-widest">Payment Status:</h4>
                    <span class="inline-block bg-black text-white px-3 py-1 text-[10px] font-bold uppercase tracking-widest">
                        {{ $transaction->payment_status }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Tabel Item --}}
        <table class="w-full mb-8">
            <thead>
                <tr class="border-b-2 border-black text-[10px] font-black uppercase">
                    <th class="py-4 text-left">Item Description</th>
                    <th class="py-4 text-center">Qty</th>
                    <th class="py-4 text-right">Unit Price</th>
                    <th class="py-4 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($transaction->items as $item)
                @php
                    $namaProduk = $item->product_name_snapshot ?? $item->product_name ?? 'Produk Lama';
                    $hargaAsli = $item->product_price_snapshot ?? $item->price ?? 0;
                    $qty = $item->quantity ?? 1;
                    $subtotal = $hargaAsli * $qty;
                @endphp
                <tr class="text-sm font-bold">
                    <td class="py-5 uppercase tracking-tighter">{{ $namaProduk }}</td>
                    <td class="py-5 text-center">{{ $qty }}</td>
                    <td class="py-5 text-right">Rp {{ number_format($hargaAsli, 0, ',', '.') }}</td>
                    <td class="py-5 text-right text-[#CD2828] font-black">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Hitungan Akhir --}}
        <div class="flex justify-end border-t-2 border-black pt-6">
            <div class="w-80">
                <div class="flex justify-between py-1 text-xs font-bold">
                    <span class="text-gray-400 tracking-wider">SUBTOTAL</span>
                    <span>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-1 text-xs font-bold">
                    <span class="text-gray-400 tracking-wider">SHIPPING COST</span>
                    <span>Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                </div>
                
                @if($transaction->admin_fee > 0)
                <div class="flex justify-between py-1 text-xs font-bold">
                    <span class="text-gray-400 tracking-wider">ADMIN FEE</span>
                    <span>Rp {{ number_format($transaction->admin_fee, 0, ',', '.') }}</span>
                </div>
                @endif
                
                @if($transaction->unique_code > 0)
                <div class="flex justify-between py-1 text-xs font-bold">
                    <span class="text-gray-400 tracking-wider">UNIQUE CODE</span>
                    <span>+{{ $transaction->unique_code }}</span>
                </div>
                @endif

                {{-- DISKON --}}
                @php
                    $totalHargaNormal = $transaction->items->sum(fn($i) => ($i->product_price_snapshot ?? $i->price ?? 0) * ($i->quantity ?? 1));
                    $totalHemat = $totalHargaNormal - $transaction->total_price;
                @endphp
                @if($totalHemat > 0)
                <div class="flex justify-between py-1 text-xs font-bold text-[#CD2828]">
                    <span class="tracking-wider">DISCOUNT</span>
                    <span>- Rp {{ number_format($totalHemat, 0, ',', '.') }}</span>
                </div>
                @endif

                <div class="flex justify-between mt-4 py-4 border-t-2 border-black bg-gray-50 px-2 print-bg-gray">
                    <span class="text-sm font-black uppercase tracking-widest">Grand Total</span>
                    <span class="text-xl font-black text-[#CD2828] print-text-red">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center">
            <p class="text-[9px] font-black uppercase tracking-[0.3em] text-gray-300">Thank you for shopping at Komditi Part</p>
        </div>
    </div>

</body>
</html>