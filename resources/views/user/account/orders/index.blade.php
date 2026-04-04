@extends('layouts.user')

@section('content')
<div class="bg-white border border-gray-100 rounded-[2.5rem] p-8 shadow-sm">
    <h3 class="text-sm font-black text-gray-800 uppercase italic tracking-widest mb-8">Riwayat Pesanan Kamu</h3>

    <div class="space-y-6">
        @forelse($orders as $order)
            <div class="border border-gray-100 rounded-[2rem] p-6 hover:shadow-md transition-all">
                <div class="flex flex-col lg:flex-row gap-6">
                    {{-- Gambar Produk Pertama --}}
                    <div class="w-24 h-24 bg-gray-100 rounded-2xl flex-shrink-0 overflow-hidden">
                        <img src="{{ asset('storage/' . $order->items->first()->product->image) }}" class="w-full h-full object-cover">
                    </div>

                    {{-- Info Singkat --}}
                    <div class="flex-1 space-y-2">
                        <h4 class="text-xs font-black text-gray-800 uppercase leading-tight">
                            {{ $order->items->first()->product->name }} 
                            @if($order->items->count() > 1) 
                                <span class="text-gray-400 font-bold ml-1">+{{ $order->items->count() - 1 }} Produk lainnya</span>
                            @endif
                        </h4>
                        <div class="flex flex-wrap gap-4 text-[10px] font-bold uppercase italic">
                            <p class="text-gray-400">Jumlah: <span class="text-gray-800">{{ $order->items->sum('quantity') }}x</span></p>
                            <p class="text-gray-400">Total: <span class="text-[#CD2828]">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span></p>
                        </div>
                        
                        {{-- Badge Status --}}
                        <div class="flex items-center gap-2">
                            <span class="text-[9px] px-3 py-1 rounded-full font-black uppercase tracking-widest
                                {{ $order->shipment_status == 'pending' ? 'bg-orange-100 text-orange-500' : '' }}
                                {{ $order->shipment_status == 'proccess' ? 'bg-blue-100 text-blue-500' : '' }}
                                {{ $order->shipment_status == 'shipped' ? 'bg-indigo-100 text-indigo-500' : '' }}
                                {{ $order->shipment_status == 'delivered' ? 'bg-cyan-100 text-cyan-500' : '' }}">
                                Status: {{ $order->shipment_status }}
                            </span>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex flex-col gap-2 justify-center border-l border-gray-100 pl-6">
                        <a href="{{ route('user.account.orders.show', $order->id) }}" class="text-cyan-400 font-black text-[10px] uppercase hover:underline">Detail Pesanan</a>
                        
                        @if($order->shipment_status == 'shipped')
                            <form action="{{ route('user.account.orders.delivered', $order->id) }}" method="POST">
                                @csrf @method('PUT')
                                <button type="submit" class="bg-cyan-400 text-white px-4 py-2 rounded-xl font-black text-[9px] uppercase tracking-widest">Selesaikan Pesanan</button>
                            </form>
                        @endif

                        @if($order->payment_status == 'waiting_verification')
                            <span class="text-gray-300 font-bold text-[9px] uppercase italic">Menunggu Konfirmasi</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center py-10 text-gray-400 italic text-xs">Belum ada pesanan.</p>
        @endforelse
    </div>
    
    <div class="mt-8">
        {{ $orders->links() }}
    </div>
</div>
@endsection