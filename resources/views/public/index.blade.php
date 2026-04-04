@extends('layouts.public') {{-- Pastikan layout app punya navbar & footer sesuai gambar --}}

@section('content')
<div class="container mx-auto px-4">
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
        <div class="md:col-span-2">
            <img src="{{ asset('images/banner-main.jpg') }}" class="rounded-3xl w-full h-full object-cover shadow-lg">
        </div>
        <div class="grid grid-rows-2 gap-4">
            <img src="{{ asset('images/banner-side1.jpg') }}" class="rounded-3xl w-full h-full object-cover shadow-md">
            <img src="{{ asset('images/banner-side2.jpg') }}" class="rounded-3xl w-full h-full object-cover shadow-md">
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
            <div class="flex-none snap-center">
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
            @foreach($bestSeller as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>

    <div class="flex justify-center mt-10">
        <a href="{{ route('public.products') }}" class="bg-red-600 text-white px-10 py-3 rounded-xl font-bold flex items-center gap-2 hover:bg-red-700 transition-all">
            Liat Semua Produk 
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
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