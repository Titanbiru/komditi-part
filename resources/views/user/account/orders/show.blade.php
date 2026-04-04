@extends('layouts.user')

@section('content')
<div class="bg-white border border-gray-100 rounded-[2.5rem] p-8 shadow-sm">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('user.account.orders.index') }}" class="p-2 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
        <h3 class="text-sm font-black text-gray-800 uppercase italic tracking-widest">Detail Pesanan</h3>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        {{-- List Produk --}}
        <div class="lg:col-span-2 space-y-6">
            @foreach($order->items as $item)
                <div class="flex gap-6 p-4 border border-gray-50 rounded-3xl">
                    <div class="w-20 h-20 bg-gray-100 rounded-2xl flex-shrink-0">
                         <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover rounded-2xl">
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-gray-800 uppercase">{{ $item->product_name_snapshot }}</h4>
                        <p class="text-[10px] font-bold text-gray-400 uppercase italic">Jumlah barang: {{ $item->quantity }}x</p>
                        <p class="text-[10px] font-black text-[#CD2828] mt-2">Harga: Rp {{ number_format($item->product_price_snapshot, 0, ',', '.') }}</p>
                    </div>
                </div>
            @endforeach

            <div class="p-6 bg-gray-50 rounded-3xl space-y-2">
                <p class="text-[10px] font-bold text-gray-400 uppercase italic">Alamat Pengiriman:</p>
                <p class="text-xs font-black text-gray-800 uppercase">{{ $order->shipping_name }} | {{ $order->shipping_phone }}</p>
                <p class="text-xs text-gray-500 leading-relaxed">{{ $order->shipping_address }}</p>
            </div>
        </div>

        {{-- Ringkasan Pembayaran --}}
        <div class="space-y-6">
            <div class="border border-gray-100 p-6 rounded-[2rem]">
                <h4 class="text-[10px] font-black text-gray-800 uppercase italic mb-4">Ringkasan Biaya</h4>
                <div class="space-y-3 text-[10px] font-bold uppercase">
                    <div class="flex justify-between text-gray-400">
                        <span>Status</span>
                        <span class="text-cyan-400 italic">{{ $order->shipment_status }}</span>
                    </div>
                    <div class="flex justify-between text-gray-400">
                        <span>Metode Bayar</span>
                        <span class="text-gray-800">{{ $order->payment_method }}</span>
                    </div>
                    <hr class="border-gray-50">
                    <div class="flex justify-between text-gray-400 font-black">
                        <span>Total Belanja</span>
                        <span class="text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-400">
                        <span>Ongkos Kirim</span>
                        <span class="text-gray-800">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-400">
                        <span>Biaya Admin</span>
                        <span class="text-gray-800">Rp {{ number_format($order->admin_fee, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between border-t border-gray-100 pt-3">
                        <span class="text-gray-800 font-black">Grand Total</span>
                        <span class="text-[#CD2828] font-black">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            
            <p class="text-[9px] text-gray-400 italic text-center uppercase font-bold">No Pesanan: {{ $order->order_number }}</p>
        </div>
    </div>
</div>
@endsection