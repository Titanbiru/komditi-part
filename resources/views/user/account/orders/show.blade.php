@extends('layouts.user')

@section('content')
<div class="bg-white border-2 border-gray-100 rounded-[2.5rem] p-8 md:p-10 shadow-sm max-w-5xl mx-auto">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 border-b border-gray-50 pb-6 gap-4">
        <div class="flex items-center gap-4">
            <h3 class="text-xl font-black text-gray-800 uppercase italic tracking-tighter">Detail Pesanan</h3>
        </div>

        {{-- LOGIKA: TOMBOL INVOICE HIDDEN JIKA BELUM SHIPPED/DELIVERED --}}
        @if(in_array($order->shipment_status, ['shipped', 'delivered']))
            <a href="{{ route('user.account.orders.invoice', $order->id) }}" target="_blank" 
            class="bg-black text-white px-5 py-2.5 rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-gray-200 hover:bg-[#CD2828] transition-all flex items-center gap-2 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak Invoice
            </a>
        @else
            {{-- Opsional: Kasih info kalau invoice belum tersedia --}}
            <div class="bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic italic">
                    Invoice tersedia setelah barang dikirim
                </p>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        {{-- KIRI: List Produk & Alamat --}}
        <div class="lg:col-span-2 space-y-8">
            
            {{-- Daftar Produk --}}
            <div class="space-y-4">
                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest pl-2">Daftar Barang</h4>
                @foreach($order->items as $item)
                    <div class="flex flex-col md:flex-row gap-6 p-4 md:p-6 border-2 border-gray-50 bg-white rounded-[2rem] hover:shadow-md transition-all">
                        
                        {{-- GAMBAR PRODUK ANTI-ERROR --}}
                        <div class="w-full md:w-24 h-24 bg-gray-50 border border-gray-100 rounded-2xl flex-shrink-0 overflow-hidden relative">
                            @php
                                $gambarProduk = $item->product?->images->first()?->image_path; 
                            @endphp

                            @if($gambarProduk)
                                <img src="{{ Storage::url($gambarProduk) }}" class="w-full h-full object-cover">
                            @else
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-300">
                                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>

                        {{-- Info Produk --}}
                        <div class="flex-1 flex flex-col justify-center">
                            <h4 class="text-sm font-black text-gray-800 uppercase leading-tight line-clamp-2">
                                {{ $item->product_name_snapshot ?? $item->product_name ?? 'Produk Dihapus' }}
                            </h4>
                            <div class="flex flex-wrap items-center gap-x-6 gap-y-2 mt-3">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                    Qty: <span class="text-gray-800 font-black">{{ $item->quantity }}x</span>
                                </p>
                                
                                {{-- LOGIKA HARGA CORET --}}
                                @php
                                    $hargaBayar = $item->product_price_snapshot ?? $item->price ?? 0;
                                    $hargaAsliMaster = $item->product ? $item->product->price : $hargaBayar;
                                @endphp

                                <div class="flex items-center gap-2">
                                    {{-- Tampilkan harga coret JIKA harga asli lebih mahal dari harga bayar --}}
                                    @if($hargaAsliMaster > $hargaBayar)
                                        <p class="text-[9px] font-bold text-gray-300 line-through">
                                            Rp {{ number_format($hargaAsliMaster, 0, ',', '.') }}
                                        </p>
                                    @endif

                                    <p class="text-[10px] font-black text-[#CD2828] tracking-wider">
                                        Rp {{ number_format($hargaBayar, 0, ',', '.') }} <span class="text-gray-400 font-bold lowercase">/pcs</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Box Alamat Pengiriman --}}
            <div class="p-8 bg-gray-50 border border-gray-100 rounded-[2rem] space-y-3">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Alamat Pengiriman</p>
                </div>
                <p class="text-sm font-black text-gray-800 uppercase">{{ $order->shipping_snapshot['recipient_name'] ?? $order->shipping_name }}</p>
                <p class="text-xs font-bold text-gray-600">{{ $order->shipping_phone }}</p>
                <p class="text-xs text-gray-500 leading-relaxed max-w-lg mt-2">{{ $order->shipping_address }}</p>
            </div>
        </div>

        {{-- KANAN: Ringkasan Pembayaran --}}
        <div class="space-y-6">
            <div class="border-2 border-gray-100 p-8 rounded-[2rem] bg-white sticky top-8 shadow-sm">
                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-6 text-center border-b border-gray-50 pb-4">Ringkasan Biaya</h4>
                
                <div class="space-y-4 text-xs font-bold uppercase tracking-wider">
                    <p class="text-[12px] text-gray-500 text-center uppercase font-black tracking-[0.2em]">
                        <span class="text-gray-500 normal-case tracking-normal">Order ID:</span>
                            {{ $order->order_number }}
                        </span> 
                    </p>
                    {{-- Status Badge --}}
                    <div class="flex flex-col gap-2 mb-6 border-b border-dashed border-gray-100 pb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] text-gray-400">Pembayaran</span>
                            <span class="px-3 py-1 rounded-full text-[9px] font-black {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                {{ $order->payment_status }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] text-gray-400">Pengiriman</span>
                            <span class="px-3 py-1 rounded-full text-[9px] font-black bg-[#1BCFD5]/10 text-[#1BCFD5]">
                                {{ $order->shipment_status }}
                            </span>
                        </div>
                    </div>

                    {{-- Rincian Angka --}}
                    <div class="flex justify-between text-gray-500">
                        <span>Total Belanja</span>
                        <span class="text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-500">
                        <span>Ongkos Kirim</span>
                        <span class="text-gray-800">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    @if($order->admin_fee > 0)
                        <div class="flex justify-between text-gray-500">
                            <span>Biaya Admin</span>
                            <span class="text-gray-800">Rp {{ number_format($order->admin_fee, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    @if($order->unique_code > 0)
                        <div class="flex justify-between text-gray-500">
                            <span>Kode Unik</span>
                            <span class="text-gray-800">+{{ $order->unique_code }}</span>
                        </div>
                    @endif

                    {{-- LOGIKA DISKON DINAMIS --}}
                    @php
                        $totalHargaNormal = 0;
                        foreach($order->items as $item) {
                            $hargaAsli = $item->product ? $item->product->price : ($item->product_price_snapshot ?? 0);
                            $totalHargaNormal += $hargaAsli * $item->quantity;
                        }
                        
                        $totalHemat = $totalHargaNormal - $order->total_price;
                    @endphp

                    @if($totalHemat > 0)
                        <div class="flex justify-between items-center bg-red-50 p-2 rounded-lg mt-2 border border-red-100">
                            <span class="text-[10px] text-[#CD2828] italic font-black">Total Diskon</span>
                            <span class="text-[#CD2828] font-black">- Rp {{ number_format($totalHemat, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    {{-- Total Akhir --}}
                    <div class="flex justify-between items-end border-t-2 border-gray-100 pt-6 mt-4">
                        <span class="text-gray-800 font-black">Grand Total</span>
                        <span class="text-xl text-[#CD2828] font-black tracking-tighter">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Nomor Resi --}}
                @if($order->resi_number)
                    <div class="mt-8 p-4 bg-yellow-50 border border-yellow-100 rounded-xl text-center">
                        <p class="text-[9px] font-black text-yellow-600 uppercase tracking-widest mb-1">No Resi J&T Express</p>
                        <p class="text-sm font-black text-gray-800 tracking-widest">{{ $order->resi_number }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection