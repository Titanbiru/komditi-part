@extends('layouts.staff')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-extrabold text-gray-800">Manage product</h1>
        <div class="relative w-72">
            <input type="text" placeholder="search" class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-full text-sm focus:outline-none focus:border-[#CD2828]">
            <svg class="w-4 h-4 absolute right-4 top-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
    </div>
    <p class="text-center text-[10px] text-gray-400 mb-6 italic">*find by category using search</p>

    <div class="bg-white border-2 border-[#CD2828] rounded-[30px] p-8 shadow-sm flex flex-col md:flex-row gap-10">
            <div class="w-full md:w-1/3">
                <div class="bg-gray-50 rounded-2xl p-4 gaborder border-gray-200">
                    @if($product->images->count() > 0)
                        <div class="w-full aspect-square flex items-center justify-center bg-white rounded-xl overflow-hidden mb-4 border border-gray-100 shadow-inner">
                            <img id="main-product-image" 
                                src="{{ Storage::url($product->images->first()->image_path) }}" 
                                class="max-w-full max-h-full object-contain transition-all duration-300">
                        </div>

                        <div class="grid grid-cols-4 gap-2">
                            @foreach($product->images as $img)
                                <div class="aspect-square rounded-lg border-2 border-transparent hover:border-[#CD2828] overflow-hidden cursor-pointer transition-all bg-white shadow-sm">
                                    <img src="{{ Storage::url($img->image_path) }}" 
                                        onclick="changeMainImage(this.src)"
                                        class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="w-full aspect-square flex items-center justify-center bg-gray-100 rounded-xl">
                            <img src="{{ asset('images/no-image.png') }}" class="w-32 opacity-20">
                        </div>
                    @endif
                </div>
            </div>

        <div class="w-full md:w-2/3 space-y-4">
            <h2 class="text-2xl font-bold text-gray-800 leading-tight uppercase">
                {{ $product->name }}
            </h2>

            <div class="mt-4 mb-6">
                @if($product->discount > 0)
                    @php
                        // Kita asumsikan $product->price di database adalah harga asli (sebelum diskon)
                        $originalPrice = $product->price;
                        $discountAmount = ($originalPrice * $product->discount) / 100;
                        $finalPrice = $originalPrice - $discountAmount;
                    @endphp

                    {{-- BARIS 1: HARGA CORET & LABEL DISKON --}}
                    <div class="flex items-center gap-3 mb-1">
                        <span class="text-lg text-gray-400 line-through decoration-red-500/50">
                            Rp {{ number_format($originalPrice, 0, ',', '.') }}
                        </span>
                        <span class="bg-[#CD2828] text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                            SAVE {{ $product->discount }}%
                        </span>
                    </div>

                    {{-- BARIS 2: HARGA UTAMA (SETELAH DISKON) --}}
                    <div class="flex items-baseline">
                        <span class="text-4xl font-black text-[#CD2828] tracking-tight">
                            Rp {{ number_format($finalPrice, 0, ',', '.') }}
                        </span>
                    </div>
                @else
                    {{-- JIKA TIDAK ADA DISKON --}}
                    <div class="flex items-baseline">
                        <span class="text-4xl font-black text-[#CD2828] tracking-tight">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>
                @endif
            </div>

            <div class="flex flex-wrap gap-2 py-2">
                @foreach($product->categories as $category)
                    <span class="bg-red-50 text-[#CD2828] text-[10px] font-bold px-3 py-1 rounded-full border border-[#CD2828] uppercase tracking-wider">
                        {{ $category->name }}
                    </span>
                @endforeach
            </div>

            <div class="flex gap-6 py-2 border-y border-gray-100">
                <div class="text-sm">
                    <span class="text-gray-500 font-medium">Being favorite by</span>
                    <span class="text-[#CD2828] font-bold ml-1">5 User</span>
                </div>
                <div class="text-sm border-x border-gray-200 px-6">
                    <span class="text-gray-500 font-medium">Weight</span>
                    <span class="text-[#CD2828] font-bold ml-1">{{ $product->weight ?? '0' }} kg</span>
                </div>
                <div class="text-sm">
                    <span class="text-gray-500 font-medium">Sales</span>
                    <span class="text-[#CD2828] font-bold ml-1">10</span>
                </div>
            </div>

            <div>
                <h3 class="font-bold text-gray-700 text-sm mb-2 uppercase tracking-widest">Spesifikasi</h3>
                <div class="text-xs text-gray-600 leading-relaxed whitespace-pre-line bg-gray-50 p-4 rounded-xl border border-gray-100 italic">
                    {{ $product->description }}
                </div>
            </div>

            <div class="pt-6">
                <a href="{{ route('admin.products.index') }}" class="bg-[#BABABA] hover:bg-gray-400 text-gray-800 px-8 py-2 rounded-full font-bold flex items-center gap-2 w-max transition-all shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                    back
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function changeMainImage(newSrc) {
        const mainImg = document.getElementById('main-product-image');
        
        // Kasih efek fade out sebentar biar halus
        mainImg.style.opacity = '0';
        
        setTimeout(() => {
            mainImg.src = newSrc;
            mainImg.style.opacity = '1';
        }, 200);
    }
</script>