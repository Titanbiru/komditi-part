<div class="bg-white border border-gray-100 rounded-[2rem] p-4 shadow-sm hover:shadow-xl transition-all duration-500 flex flex-col h-full group relative">
    
    {{-- Container Gambar --}}
    <div class="relative group">
        
        {{-- Tombol Favorit --}}
        @auth
            @php
                $isFavorite = Auth::user()->favorites()->where('product_id', $product->id)->exists();
            @endphp
            <button type="button" 
                onclick="toggleFavorite({{ $product->id }})" 
                id="fav-icon-card-{{ $product->id }}"
                class="absolute top-3 right-3 z-20 p-2 rounded-full backdrop-blur-md transition-all duration-300 {{ $isFavorite ? 'bg-red-500 text-white' : 'bg-white/80 text-gray-400 hover:text-red-500 shadow-sm' }}">
                <svg class="w-4 h-4 {{ $isFavorite ? 'fill-current' : 'fill-none' }}" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </button>
        @endauth

        {{-- LABEL DISKON (Ambil dari $product->discount) --}}
        @if($product->discount > 0)
            <div class="absolute top-3 left-3 z-20 bg-[#CD2828] text-white text-[9px] font-black px-2.5 py-1.5 rounded-xl shadow-lg shadow-red-200 uppercase italic tracking-tighter">
                -{{ $product->discount }}%
            </div>
        @endif

        <a href="{{ route('public.products.show', $product->slug) }}" 
            class="bg-[#F8F8F8] rounded-[1.5rem] p-4 mb-4 aspect-square flex items-center justify-center overflow-hidden relative group-hover:bg-red-50 transition-colors duration-500 block">
            <img src="{{ $product->thumbnail }}" 
                alt="{{ $product->name }}" 
                class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-500">
        </a>
    </div>
    
    {{-- Info Produk --}}
    <div class="flex-grow px-1 mb-3">
        <a href="{{ route('public.products.show', $product->slug) }}" class="block">
            <h3 class="text-[11px] font-black uppercase text-gray-500 tracking-tighter leading-tight line-clamp-2 h-8 hover:text-[#CD2828] transition-colors">
                {{ $product->name }}
            </h3>
        </a>
        
        {{-- BAGIAN HARGA (LOGIKA SESUAI HALAMAN DETAIL) --}}
        <div class="mt-3 flex flex-col">
            @if($product->discount > 0)
                @php
                    $originalPrice = $product->price;
                    $finalPrice = $originalPrice - ($originalPrice * $product->discount / 100);
                @endphp
                
                {{-- Harga Coret (Harga Asli) --}}
                <span class="text-[10px] font-bold text-gray-400 line-through decoration-red-500/50 h-4">
                    Rp {{ number_format($originalPrice, 0, ',', '.') }}
                </span>

                {{-- Harga Utama (Harga Setelah Diskon) --}}
                <div class="flex items-baseline gap-0.5 -mt-1">
                    <span class="text-[10px] font-black text-[#CD2828]">Rp</span>
                    <span class="text-lg font-black text-[#CD2828] tracking-tighter">
                        {{ number_format($finalPrice, 0, ',', '.') }}
                    </span>
                </div>
            @else
                {{-- Tampilan Jika Tidak Ada Diskon --}}
                <div class="h-4"></div> 
                <div class="flex items-baseline gap-0.5 -mt-1">
                    <span class="text-[10px] font-black text-black">Rp</span>
                    <span class="text-lg font-black text-black tracking-tighter">
                        {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                </div>
            @endif
        </div>
    </div>

    {{-- Tombol Aksi --}}
    <div class="grid grid-cols-5 gap-2 mt-auto">
        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="col-span-4">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button type="submit" class="bg-[#CD2828] text-white w-full py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-black active:scale-95 transition-all shadow-lg shadow-red-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4(5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Tambah
            </button>
        </form>

        <a href="{{ route('public.products.show', $product->slug) }}" 
            class="col-span-1 bg-gray-100 text-gray-400 rounded-2xl flex items-center justify-center hover:bg-black hover:text-white transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
</div>

<script>
/**
 * Fungsi Global untuk Toggle Favorit
 * Bisa dipanggil dari halaman Detail maupun dari Card Produk di Home/Katalog
 */
function toggleFavorite(productId) {
    // 1. Cek Meta CSRF (Wajib ada di Head layout)
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    if (!csrfToken) {
        console.error('CSRF token not found. Pastikan ada <meta name="csrf-token" ...> di layout.');
        return;
    }

    // 2. URL Route (Pastikan nama route sesuai web.php Mas)
    // Kita gunakan helper route() Laravel untuk generate URL yang benar
    const url = "{{ route('user.account.favorites.toggle', ':id') }}".replace(':id', productId);

    // 3. Efek Visual Instan (Optimistic UI)
    // Kita cari semua elemen yang berhubungan dengan ID produk ini
    const btnDetail = document.getElementById(`fav-btn-${productId}`);
    const iconDetail = document.getElementById(`fav-icon-${productId}`);
    const cardIcon = document.getElementById(`fav-icon-card-${productId}`);
    const countText = document.getElementById(`fav-count-${productId}`);

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        // Jika 401 (Unauthorized), tendang ke login
        if (response.status === 401) {
            window.location.href = "{{ route('login') }}";
            return;
        }
        if (!response.ok) throw new Error('Server error');
        return response.json();
    })
    .then(data => {
        if (!data) return;

        // --- UPDATE TAMPILAN DI HALAMAN DETAIL (Jika ada) ---
        if (btnDetail && iconDetail) {
            if (data.status === 'added') {
                btnDetail.classList.replace('text-gray-400', 'text-red-500');
                iconDetail.classList.add('fill-current');
                // Animasi detak jantung kecil
                btnDetail.classList.add('scale-110');
                setTimeout(() => btnDetail.classList.remove('scale-110'), 200);
            } else {
                btnDetail.classList.replace('text-red-500', 'text-gray-400');
                iconDetail.classList.remove('fill-current');
            }
        }

        // --- UPDATE TAMPILAN DI CARD PRODUK (Jika ada) ---
        if (cardIcon) {
            if (data.status === 'added') {
                cardIcon.classList.remove('bg-white/80', 'text-gray-400');
                cardIcon.classList.add('bg-red-500', 'text-white');
                cardIcon.querySelector('svg').classList.add('fill-current');
            } else {
                cardIcon.classList.remove('bg-red-500', 'text-white');
                cardIcon.classList.add('bg-white/80', 'text-gray-400');
                cardIcon.querySelector('svg').classList.remove('fill-current');
            }
        }

        // --- UPDATE ANGKA FAVORIT (Social Proof) ---
        if (countText) {
            countText.innerText = `${data.count} Menyukai`;
        }

        // --- UPDATE BADGE DI HEADER (Penanda Jumlah Favorit User) ---
        // Kita asumsikan ID badge di header adalah 'header-fav-count'
        const headerBadge = document.getElementById('header-fav-count');
        if (headerBadge) {
            // Kita perlu hitung ulang atau ambil dari response jika Mas kirim totalCount
            // Untuk sementara, kita bisa trigger refresh kecil atau biarkan tetap 
            // jika Mas tidak mengirimkan total jumlah favorit user di JSON response.
            // Opsi: Mas bisa tambahkan 'totalFavorites' => Auth::user()->favorites()->count() di Controller.
        }
    })
    .catch(error => {
        console.error('Favorite Error:', error);
    });
}

/**
 * Fungsi Tambahan untuk Quantity di Detail Produk
 */
function changeQty(amt, maxStock) {
    const input = document.getElementById('qty-input');
    const formInput = document.getElementById('form-qty');
    if (!input || !formInput) return;

    let val = parseInt(input.value) + amt;
    
    if (val < 1) val = 1;
    if (val > maxStock) {
        val = maxStock;
        alert('Stok tidak mencukupi Mas!');
    }
    
    input.value = val;
    formInput.value = val;
}
</script>