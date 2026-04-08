@extends('layouts.public')

@section('content')

<div class="container mx-auto px-4">
    {{-- Main Container --}}
    <div class="bg-white border-2 border-gray-100 rounded-[40px]  md:p-12 shadow-sm">
        
        <div class="flex flex-col lg:flex-row gap-12">
            {{-- KIRI: GALERI FOTO --}}
            <div class="w-full lg:w-1/3">
                <div class="bg-gray-50 rounded-[2.5rem] p-4 border border-gray-100">
                    @if($product->images->count() > 0)
                        <div class="w-full aspect-square flex items-center justify-center bg-white rounded-3xl overflow-hidden mb-4 border border-gray-100 shadow-inner">
                            {{-- Gunakan Storage::url seperti di Admin --}}
                            <img id="main-product-image" 
                                src="{{ Storage::url($product->images->first()->image_path) }}" 
                                class="max-w-full max-h-full object-contain transition-all duration-300">
                        </div>

                        <div class="grid grid-cols-4 gap-2">
                            @foreach($product->images as $img)
                                <div class="aspect-square rounded-xl border-2 {{ $loop->first ? 'border-[#CD2828]' : 'border-transparent' }} hover:border-[#CD2828] overflow-hidden cursor-pointer transition-all bg-white shadow-sm thumbnail-item">
                                    <img src="{{ Storage::url($img->image_path) }}" 
                                        onclick="changeMainImage(this.src, this)"
                                        class="w-full h-full object-contain p-1">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="w-full aspect-square flex items-center justify-center bg-gray-100 rounded-3xl">
                            <img src="{{ asset('images/no-image.png') }}" class="w-32 opacity-20">
                        </div>
                    @endif
                </div>
            </div>

            {{-- KANAN: AREA DETAIL --}}
            <div class="w-full lg:w-2/3 flex flex-col">
                {{-- Judul & Harga Utama --}}
                <div class="space-y-4 mb-6">
                    <h1 class="text-2xl md:text-4xl font-black text-gray-800 uppercase leading-tight tracking-tighter italic">
                        {{ $product->name }}
                    </h1>
                    
                    <div class="flex items-center flex-wrap gap-4">
                        @if($product->discount > 0)
                            @php
                                $originalPrice = $product->price;
                                $finalPrice = $originalPrice - ($originalPrice * $product->discount / 100);
                            @endphp
                            {{-- Harga Setelah Diskon (Highlight) --}}
                            <div class="flex flex-col">
                                <span class="text-3xl font-black text-[#CD2828] leading-none">
                                    Rp {{ number_format($finalPrice, 0, ',', '.') }}
                                </span>
                                {{-- Harga Sebelum Diskon (Coret) --}}
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-sm font-bold text-gray-400 line-through">
                                        Rp {{ number_format($originalPrice, 0, ',', '.') }}
                                    </span>
                                    <span class="bg-[#CD2828]/10 text-[#CD2828] text-[10px] font-black px-2 py-0.5 rounded-lg border border-red-100">
                                        Hemat {{ $product->discount }}%
                                    </span>
                                </div>
                            </div>
                        @else
                            <span class="text-3xl font-black text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @endif
                        
                        {{-- Statistik Favorit & Terjual --}}
                        <div class="flex items-center gap-3 ml-auto">
                            {{-- Cek apakah user sudah memfavoritkan produk ini --}}
                            @php
                                $isFavorite = Auth::check() ? Auth::user()->favorites()->where('product_id', $product->id)->exists() : false;
                            @endphp

                            <button type="button" 
                                    onclick="toggleFavorite({{ $product->id }})" 
                                    id="fav-btn-{{ $product->id }}"
                                    class="ml-auto flex items-center gap-2 transition-all {{ $isFavorite ? 'text-red-500' : 'text-gray-400' }} hover:text-red-500 group">
                                
                                <svg id="fav-icon-{{ $product->id }}" 
                                    class="w-6 h-6 {{ $isFavorite ? 'fill-current' : 'fill-none' }}" 
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" 
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                
                                <div class="flex flex-col items-start leading-none">
                                    <span class="text-[10px] font-black uppercase tracking-widest">Favorit</span>
                                    <span id="fav-count-{{ $product->id }}" class="text-[9px] font-bold text-gray-400 group-hover:text-red-300">
                                        {{ $product->favoritedBy()->count() }} Menyukai
                                    </span>
                                </div>
                            </button>
                            <div class="w-[1px] h-8 bg-gray-100"></div>
                            <div class="flex flex-col items-end">
                                <span class="text-[10px] font-black text-gray-400 uppercase italic">Terjual</span>
                                <span class="text-xs font-black text-gray-800">{{ $product->orderItems()->whereHas('order', fn($q) => $q->where('payment_status', 'paid'))->sum('quantity') ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Konten Utama (Deskripsi vs Sidebar Beli) --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 border-t border-gray-100 pt-8">
                    
                    {{-- Kolom Kiri: Deskripsi (Lebih Lebar) --}}
                    <div class="md:col-span-2 space-y-6">
                        <div class="inline-block border-b-4 border-[#CD2828] pb-1">
                            <h3 class="text-sm font-black uppercase tracking-widest text-gray-800 ">Deskripsi</h3>
                        </div>
                        <div class="text-sm text-gray-600 leading-relaxed">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>

                    {{-- Kolom Kanan: Sidebar Beli --}}
                    <div class="md:col-span-1 space-y-6">
                        {{-- Status Stok --}}
                        <div class="bg-gray-50 p-5 rounded-[2rem] border border-gray-100 space-y-3">
                            <div class="flex justify-between items-end">
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Ketersediaan</span>
                                    <span class="text-xs font-black {{ $product->stock > 0 ? 'text-cyan-500' : 'text-red-500' }} uppercase leading-none">
                                        {{ $product->stock > 0 ? 'Stok Tersedia' : 'Stok Habis' }}
                                    </span>
                                </div>
                                <span class="text-[10px] font-bold text-gray-500 italic">{{ $product->stock }} Item tersisa</span>
                            </div>
                            
                            {{-- Progress Bar Stok (Visual) --}}
                            {{-- Progress Bar Stok --}}
                            <div class="w-full h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                @php
                                    // Misal kita asumsikan stok "aman" itu kalau di atas 20
                                    $maxVisual = 20; 
                                    $width = ($product->stock / $maxVisual) * 100;
                                    if($width > 100) $width = 100;
                                @endphp
                                <div class="h-full {{ $product->stock <= 5 ? 'bg-[#CD2828]' : 'bg-[#1BCFD5]' }} rounded-full transition-all duration-1000" 
                                    style="width: {{ $width }}%"></div>
                            </div>
                            @if($product->stock <= 5 && $product->stock > 0)
                                <p class="text-[9px] font-bold text-red-500 animate-pulse italic">Segera habis! Sisa {{ $product->stock }} lagi</p>
                            @endif
                        </div>

                        {{-- Kotak Beli --}}
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic">Subtotal :</span>
                                <span class="text-xl font-black text-gray-800">
                                    Rp {{ number_format($product->discount > 0 ? $finalPrice : $product->price, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between gap-3">
                                @if($product->stock > 0)
                                    {{-- Quantity --}}
                                    <div class="flex items-center bg-white border border-gray-200 rounded-xl p-1 shadow-sm">
                                        <button type="button" onclick="changeQty(-1)" class="w-8 h-8 flex items-center justify-center font-black text-gray-400 hover:text-[#CD2828]">-</button>
                                        <input type="number" id="qty-input" value="1" min="1" max="{{ $product->stock }}" class="w-8 text-center bg-transparent font-black text-sm text-gray-800 focus:outline-none appearance-none" readonly>
                                        <button type="button" onclick="changeQty(1)" class="w-8 h-8 flex items-center justify-center font-black text-gray-400 hover:text-[#CD2828]">+</button>
                                    </div>

                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-grow">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" id="form-qty" value="1">
                                        <button type="submit" class="w-full bg-[#CD2828] text-white py-3 rounded-xl font-black text-[10px] uppercase flex items-center justify-center gap-2 hover:bg-black transition-all shadow-lg shadow-red-100">
                                            Tambah Ke Keranjang
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="w-full bg-gray-200 text-gray-400 py-3 rounded-xl font-black text-[10px] uppercase cursor-not-allowed">
                                        Stok Habis
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function changeMainImage(newSrc, element) {
        const mainImg = document.getElementById('main-product-image');
        mainImg.style.opacity = '0';
        document.querySelectorAll('.thumbnail-item').forEach(item => {
            item.classList.remove('border-[#CD2828]');
            item.classList.add('border-transparent');
        });
        element.classList.add('border-[#CD2828]');
        element.classList.remove('border-transparent');
        setTimeout(() => {
            mainImg.src = newSrc;
            mainImg.style.opacity = '1';
        }, 200);
    }

    function changeQty(amt) {
        const input = document.getElementById('qty-input');
        const formInput = document.getElementById('form-qty');
        let val = parseInt(input.value) + amt;
        if (val < 1) val = 1;
        input.value = val;
        formInput.value = val;
    }

    function toggleFavorite(productId) {
    // Gunakan route name yang persis ada di web.php Mas
        const url = "{{ route('user.account.favorites.toggle', ':id') }}".replace(':id', productId);

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (response.status === 401) {
                // Jika user belum login
                window.location.href = "{{ route('login') }}";
                return;
            }
            return response.json();
        })
        .then(data => {
            if(!data) return;

            const btn = document.getElementById(`fav-btn-${productId}`);
            const icon = document.getElementById(`fav-icon-${productId}`);
            const countText = document.getElementById(`fav-count-${productId}`);

            if (data.status === 'added') {
                btn.classList.remove('text-gray-400');
                btn.classList.add('text-red-500');
                icon.classList.add('fill-current');
            } else {
                btn.classList.remove('text-red-500');
                btn.classList.add('text-gray-400');
                icon.classList.remove('fill-current');
            }
            
            countText.innerText = `${data.count} Menyukai`;
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection