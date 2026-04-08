@extends('layouts.public') {{-- Pastikan layout app punya navbar & footer sesuai gambar --}}

@section('content')
<div class="container mx-auto px-4">
    
    {{-- Banner / Hero Image --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-10">
        
        {{-- 1. BANNER UTAMA (Ambil 3 Kolom) --}}
        <div class="md:col-span-3">
            <div class="rounded-[2.5rem] overflow-hidden border-2 border-black bg-white h-[200px] md:h-[416px] ">
                <img src="{{ Storage::url(get_setting('hero_image')) }}" 
                    class="w-full h-full object-cover object-center">
            </div>
        </div>

        {{-- 2. BANNER SIDE (Ambil 1 Kolom Sisanya) --}}
        {{-- Pakai flex-col dan h-full biar tingginya sama persis sama sebelah --}}
        <div class="hidden md:flex flex-col gap-4 h-[416px]">
            
            {{-- Banner Side 1 (1:1) --}}
            <div class="flex-1 overflow-hidden">
                <div class="rounded-[2rem] overflow-hidden border-2 border-black bg-white h-full">
                    <img src="{{ Storage::url(get_setting('hero_side_1')) }}" 
                        class="w-full h-full object-cover">
                </div>
            </div>

            {{-- Banner Side 2 (1:1) --}}
            <div class="flex-1 overflow-hidden">
                <div class="rounded-[2rem] overflow-hidden border-2 border-black bg-white h-full">
                    <img src="{{ Storage::url(get_setting('hero_side_2')) }}" 
                        class="w-full h-full object-cover">
                </div>
            </div>

        </div>
    </div>

    <div class="relative group px-4"> 
        <button onclick="scrollCat(-300)" 
                class="absolute left-0 top-12 bg-white text-black p-3 rounded-full shadow-2xl border border-gray-100 
                opacity-0 group-hover:opacity-100 hover:bg-[#CD2828] hover:text-white transition-all duration-300 z-20 -translate-x-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>

        <div id="category-container" 
            class="flex overflow-x-auto gap-10 pb-10 no-scrollbar scroll-smooth snap-x snap-mandatory px-12"> 
            @foreach($categories as $category)
            <div class="flex-none snap-center pt-4">
                <a href="{{ route('public.category', $category->slug) }}" class="group/item flex flex-col items-center">
                    <div class="w-24 h-24 bg-white border-2 border-gray-100 rounded-[2rem] flex items-center justify-center 
                            shadow-sm transition-all duration-500 
                            group-hover/item:border-[#CD2828] group-hover/item:shadow-xl group-hover/item:-translate-y-2 
                            relative overflow-hidden p-5">
                        
                        <div class="absolute inset-0 bg-red-50 opacity-0 group-hover/item:opacity-100 transition-opacity duration-500"></div>

                        @if($category->icon)
                            <img src="{{ asset($category->icon) }}?v={{ time() }}" 
                                class="w-full h-full object-contain relative z-10 transition-all duration-500 
                                        grayscale group-hover/item:grayscale-0 group-hover/item:scale-110">
                        @else
                            <span class="text-[10px] font-bold text-gray-300 relative z-10">NO ICON</span>
                        @endif
                    </div>

                    <span class="mt-4 text-sm font-black uppercase tracking-wider text-gray-500 
                                group-hover/item:text-[#CD2828] transition-colors duration-300">
                        {{ $category->name }}
                    </span>
                </a>
            </div>
            @endforeach
        </div>

        <button onclick="scrollCat(300)" 
                class="absolute right-0 top-12 bg-white text-black p-3 rounded-full shadow-2xl border border-gray-100 
                    opacity-0 group-hover:opacity-100 hover:bg-[#CD2828] hover:text-white transition-all duration-300 z-20 translate-x-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
    </div>

    <div class="mb-12">
        <h2 class="text-xl font-bold mb-6">Promo</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($promoProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>

    <div class="mb-12">
        <h2 class="text-xl font-bold mb-6">Produk <span class="text-red-600">Terlaris</span></h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @php
                    // Kita hitung total penjualan untuk setiap produk
                    $bestSeller = $products->sortByDesc(function($product) {
                        return $product->orderItems->sum(function($item) {
                            return $item->quantity;
                        });
                    })->take(6); // Ambil 6 produk terlaris
                @endphp
            @foreach($bestSeller as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>

    <div class="flex justify-center mt-16 mb-20">
        <a href="{{ route('public.products') }}" 
            class="group bg-[#CD2828] text-white px-12 py-4 rounded-[1.5rem] font-black text-[10px] uppercase tracking-[0.2em] flex items-center gap-3 hover:bg-[#832A2A] transition-all duration-500 shadow-xl shadow-gray-200">
            Eksplor Semua Produk 
            <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>
</div>

<style>
    /* Sembunyikan scrollbar tapi tetap bisa digeser */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    /* Tambahan agar scroll terasa halus di PC */
    #category-container {
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
    }
</style>

<script>
    function scrollCat(val) {
        const container = document.getElementById('category-container');
        container.scrollBy({
            left: val,
            behavior: 'smooth'
        });
    }
</script>
@endsection