@extends('layouts.public')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex flex-col lg:flex-row gap-10">
        
        {{-- SISI KIRI: DAFTAR ITEM --}}
        <div class="w-full lg:w-2/3">
            <div class="bg-white border-2 border-gray-100 rounded-[2.5rem] p-8 shadow-sm">
                <div class="flex items-center justify-between mb-10">
                    <h1 class="text-xl font-black text-gray-800 italic uppercase tracking-tighter">Keranjang Kamu</h1>
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest bg-gray-50 px-4 py-1 rounded-full">
                        {{ $cart && $cart->items->count() > 0 ? $cart->items->count() . ' Jenis Barang' : 'Kosong' }}
                    </span>
                </div>

                @if($cart && $cart->items->count() > 0)
                    <div class="space-y-8">
                        @foreach($cart->items as $item)
                            <div class="flex flex-col md:flex-row items-center gap-6 pb-8 border-b border-gray-100 last:border-0 last:pb-0 group">
                                
                                {{-- Checkbox & Gambar --}}
                                <div class="flex items-center gap-4 flex-shrink-0">
                                    <input type="checkbox" class="w-5 h-5 accent-[#CD2828] rounded-xl border-gray-200 cursor-pointer">
                                    
                                    <a href="{{ route('public.products.show', $item->product->slug) }}" class="w-24 h-24 bg-gray-50 rounded-[1.5rem] border border-gray-100 flex items-center justify-center p-3 hover:bg-red-50 transition-colors duration-300">
                                        <img src="{{ Storage::url($item->product->images->first()->image_path ?? 'no-image.png') }}" 
                                            class="max-w-full max-h-full object-contain group-hover:scale-110 transition-transform duration-500">
                                    </a>
                                </div>

                                {{-- Info Produk --}}
                                <div class="flex-grow space-y-1">
                                    <a href="{{ route('public.products.show', $item->product->slug) }}" class="inline-block">
                                        <h3 class="text-sm font-black text-gray-800 uppercase leading-tight hover:text-[#CD2828] transition-colors line-clamp-2">
                                            {{ $item->product->name }}
                                        </h3>
                                    </a>
                                    <div class="flex items-center gap-3">
                                        <span class="text-xs font-black text-[#CD2828]">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                        @if($item->product->price > $item->price)
                                            <span class="text-[10px] text-gray-300 line-through">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase italic pt-1">
                                        Subtotal: <span class="text-gray-800 font-black">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                    </p>
                                </div>

                                {{-- Kontrol Quantity & Hapus --}}
                                <div class="flex items-center gap-6 w-full md:w-auto justify-between md:justify-end">
                                    <div class="flex items-center bg-white border-2 border-gray-100 rounded-2xl p-1 shadow-sm">
                                        {{-- Tombol Kurang --}}
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="action" value="decrease">
                                            <button type="submit" class="w-9 h-9 flex items-center justify-center font-black text-gray-400 hover:text-[#CD2828] hover:bg-gray-50 rounded-xl transition-all">-</button>
                                        </form>

                                        <span class="w-10 text-center font-black text-sm text-gray-800">{{ $item->quantity }}</span>

                                        {{-- Tombol Tambah --}}
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="action" value="increase">
                                            <button type="submit" class="w-9 h-9 flex items-center justify-center font-black text-gray-400 hover:text-[#CD2828] hover:bg-gray-50 rounded-xl transition-all">+</button>
                                        </form>
                                    </div>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-3 bg-gray-50 text-gray-300 hover:bg-red-50 hover:text-red-600 rounded-2xl transition-all shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-20 bg-gray-50 rounded-[2rem] border-2 border-dashed border-gray-100">
                        <p class="text-gray-400 italic font-bold uppercase text-xs tracking-widest">Wah, keranjangmu masih kosong nih...</p>
                        <a href="{{ route('public.products') }}" class="inline-block mt-6 bg-black text-white px-8 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-[#CD2828] transition-all shadow-lg shadow-gray-200">Mulai Belanja</a>
                    </div>
                @endif
            </div>
        </div>

        {{-- SISI KANAN: RINGKASAN --}}
        <div class="w-full lg:w-1/3">
            <div class="bg-white border-2 border-gray-100 rounded-[2.5rem] p-8 shadow-sm sticky top-8">
                <h2 class="text-xs font-black text-gray-400 mb-8 uppercase tracking-widest italic border-b border-gray-50 pb-4 text-center">Ringkasan belanja</h2>
                
                <div class="space-y-4">
                    @php
                        $totalHargaAsli = $cart ? $cart->items->sum(fn($i) => $i->product->price * $i->quantity) : 0;
                        $totalDiskon = $cart ? $cart->items->sum(fn($i) => ($i->product->price - $i->price) * $i->quantity) : 0;
                        $totalFinal = $cart ? $cart->items->sum(fn($i) => $i->price * $i->quantity) : 0;
                    @endphp

                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-gray-400 uppercase italic">Harga Normal</span>
                        <span class="text-sm font-black text-gray-800 tracking-tighter">Rp {{ number_format($totalHargaAsli, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-gray-400 uppercase italic">Jumlah Barang</span>
                        <span class="text-sm font-black text-gray-800">{{ $cart ? $cart->items->sum('quantity') : 0 }} Item</span>
                    </div>

                    @if($totalDiskon > 0)
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-black text-red-400 uppercase italic tracking-tighter">Total Hemat</span>
                            <span class="text-sm font-black text-red-500">- Rp {{ number_format($totalDiskon, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <div class="pt-6 border-t-2 border-dashed border-gray-100 flex justify-between items-center mt-6">
                        <span class="text-xs font-black text-gray-800 uppercase italic">Total Bayar</span>
                        <span class="text-2xl font-black text-[#CD2828] tracking-tighter shadow-red-50">Rp {{ number_format($totalFinal, 0, ',', '.') }}</span>
                    </div>

                    <div class="pt-8">
                        <a href="{{ route('checkout.index') }}" class="block">
                            <button class="w-full bg-[#CD2828] text-white py-4 rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-black hover:shadow-2xl hover:shadow-red-200 transition-all active:scale-95">
                                Checkout
                            </button>
                        </a>
                        <p class="text-[8px] text-gray-400 text-center mt-4 font-bold uppercase tracking-widest italic leading-relaxed">
                            *Harga sudah termasuk PPN & Biaya Penanganan
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    function changeQty(amt) {
        const input = document.getElementById('qty-input');
        const formInput = document.getElementById('form-qty');
        let val = parseInt(input.value) + amt;
        
        if (val < 1) val = 1; // Biar gak bisa minus
        
        input.value = val;
        formInput.value = val;
    }
</script>
@endsection