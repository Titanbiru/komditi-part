@extends('layouts.public')

@section('content')
<div class="container mx-auto px-4">
    {{-- 1. BUNGKUS DENGAN FORM AGAR DATA TERKIRIM KE CHECKOUT --}}
    <form action="{{ route('checkout.index') }}" method="GET">
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
                                    
                                    {{-- Checkbox & Gambar (Optimasi HP & PC) --}}
                                    <div class="flex items-center gap-3 md:gap-6 flex-shrink-0 w-full md:w-auto">
                                        
                                        {{-- Checkbox: Dikunci lebarnya biar gak kedorong --}}
                                        <div class="flex-shrink-0">
                                            <input type="checkbox" name="cart_ids[]" value="{{ $item->id }}" 
                                                class="cart-checkbox w-6 h-6 md:w-7 md:h-7 accent-[#CD2828] rounded-lg border-2 border-gray-200 cursor-pointer transition-transform active:scale-90"
                                                data-price="{{ $item->price }}" 
                                                data-qty="{{ $item->quantity }}"
                                                data-original="{{ $item->product->price }}"
                                                onchange="updateSummary()" checked>
                                        </div>
                                        
                                        {{-- Gambar: Ukuran Dinamis (Kecil di HP, Besar di PC) --}}
                                        <div class="relative flex-shrink-0 group">
                                            <a href="{{ route('public.products.show', $item->product->slug) }}" 
                                            class="block w-20 h-20 md:w-32 md:h-32 bg-[#F9F9F9] rounded-[1.5rem] md:rounded-[2rem] border-2 border-gray-100 overflow-hidden hover:border-[#CD2828] transition-all duration-500 shadow-sm">
                                                <div class="w-full h-full p-3 md:p-4 flex items-center justify-center">
                                                    <img src="{{ Storage::url($item->product->images->first()->image_path ?? 'no-image.png') }}" 
                                                        class="max-w-full max-h-full object-contain group-hover:scale-110 transition-transform duration-700">
                                                </div>
                                            </a>

                                            @if($item->product->price > $item->price)
                                                <div class="absolute -top-1 -left-1 bg-[#CD2828] text-white text-[7px] md:text-[12px] font-black px-2 py-0.5 rounded-full uppercase italic shadow-md rotate-[-12deg] z-10">
                                                    OFF!
                                                </div>
                                            @endif
                                        </div>
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

                                    {{-- Info Qty (Tampilan Saja karena update pakai form terpisah) --}}
                                    {{-- Ganti bagian Loop Quantity Mas dengan ini --}}
                                    <div class="flex items-center gap-6 w-full md:w-auto justify-between md:justify-end">
                                        <div class="flex items-center bg-white border-2 border-gray-100 rounded-2xl p-1 shadow-sm">
                                            {{-- Tombol Kurang --}}
                                            <button type="button" 
                                                onclick="updateQty('{{ $item->id }}', -1)"
                                                class="w-9 h-9 flex items-center justify-center font-black text-gray-400 hover:text-[#CD2828] hover:bg-red-50 rounded-xl transition-all active:scale-90">
                                                -
                                            </button>

                                            {{-- Input Angka (ReadOnly biar user gak ngetik ngasal) --}}
                                            <input type="text" 
                                                id="qty-input-{{ $item->id }}" 
                                                value="{{ $item->quantity }}" 
                                                class="w-10 text-center font-black text-sm text-gray-800 bg-transparent border-none focus:ring-0" 
                                                readonly>

                                            {{-- Tombol Tambah --}}
                                            <button type="button" 
                                                onclick="updateQty('{{ $item->id }}', 1)"
                                                class="w-9 h-9 flex items-center justify-center font-black text-gray-400 hover:text-[#CD2828] hover:bg-red-50 rounded-xl transition-all active:scale-90">
                                                +
                                            </button>
                                        </div>

                                        {{-- Tombol Hapus (Tetap pakai form karena ini aksi fatal) --}}
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-3 bg-gray-50 text-gray-300 hover:bg-red-50 hover:text-red-600 rounded-2xl transition-all shadow-sm active:scale-95">
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
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-black text-gray-400 uppercase italic">Harga Normal</span>
                            <span id="summary-original" class="text-sm font-black text-gray-800 tracking-tighter">Rp 0</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-black text-gray-400 uppercase italic">Jumlah Barang</span>
                            <span id="summary-qty" class="text-sm font-black text-gray-800">0 Item</span>
                        </div>

                        <div id="container-hemat" class="flex justify-between items-center">
                            <span class="text-[10px] font-black text-red-400 uppercase italic tracking-tighter">Total Hemat</span>
                            <span id="summary-save" class="text-sm font-black text-red-500">- Rp 0</span>
                        </div>

                        <div class="pt-6 border-t-2 border-dashed border-gray-100 flex justify-between items-center mt-6">
                            <span class="text-xs font-black text-gray-800 uppercase italic">Total Bayar</span>
                            <span id="summary-total" class="text-2xl font-black text-[#CD2828] tracking-tighter shadow-red-50">Rp 0</span>
                        </div>

                        <div class="pt-8">
                            <button type="submit" class="w-full bg-[#CD2828] text-white py-4 rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-black hover:shadow-2xl hover:shadow-red-200 transition-all active:scale-95">
                                Checkout
                            </button>
                            <p class="text-[8px] text-gray-400 text-center mt-4 font-bold uppercase tracking-widest italic leading-relaxed">
                                *Harga sudah termasuk PPN & Biaya Penanganan
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // FUNGSI UPDATE RINGKASAN OTOMATIS
    function updateQty(itemId, change) {
        const input = document.getElementById('qty-input-' + itemId);
        const checkbox = document.querySelector(`input[value="${itemId}"].cart-checkbox`);
        let currentQty = parseInt(input.value);
        let newQty = currentQty + change;

        if (newQty < 1) return; // Minimal 1 barang

        // 1. Tampilkan loading sebentar (Opsional)
        input.style.opacity = '0.5';

        // 2. Kirim ke Backend
        fetch(`/cart/update/${itemId}`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ action: change > 0 ? 'increase' : 'decrease' })
        })
        .then(response => response.json())
        .then(data => {
            input.value = newQty;
            input.style.opacity = '1';
            
            // Update Data Attribute di Checkbox agar kalkulasi Ringkasan ikut berubah
            checkbox.setAttribute('data-qty', newQty);
            
            // Panggil fungsi hitung total yang kita buat tadi
            updateSummary(); 
        })
        .catch(error => {
            console.error('Error:', error);
            input.style.opacity = '1';
        });
    }

    // Fungsi Hitung Total (Sama seperti sebelumnya tapi pastikan ID-nya pas)
    function updateSummary() {
        let originalPriceTotal = 0;
        let finalPriceTotal = 0;
        let totalItems = 0;

        const selectedItems = document.querySelectorAll('.cart-checkbox:checked');

        selectedItems.forEach(item => {
            const price = parseInt(item.getAttribute('data-price'));
            const original = parseInt(item.getAttribute('data-original'));
            const qty = parseInt(item.getAttribute('data-qty'));

            originalPriceTotal += (original * qty);
            finalPriceTotal += (price * qty);
            totalItems += qty;
        });

        const totalSave = originalPriceTotal - finalPriceTotal;

        document.getElementById('summary-original').innerText = 'Rp ' + originalPriceTotal.toLocaleString('id-ID');
        document.getElementById('summary-qty').innerText = totalItems + ' Item';
        document.getElementById('summary-total').innerText = 'Rp ' + finalPriceTotal.toLocaleString('id-ID');
        
        const saveLabel = document.getElementById('summary-save');
        if (totalSave > 0) {
            document.getElementById('container-hemat').style.display = 'flex';
            saveLabel.innerText = '- Rp ' + totalSave.toLocaleString('id-ID');
        } else {
            document.getElementById('container-hemat').style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', updateSummary);
</script>
@endsection