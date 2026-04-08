@extends('layouts.admin')

@section('content')
<div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 px-2">
    <div>
        <div class="flex items-center gap-3 mb-1">
            <h1 class="text-2xl font-black text-[#202020] uppercase tracking-tighter">Product Detail</h1>
            
            {{-- BADGE STATUS --}}
            <span class="px-3 py-0.5 rounded-full text-[8px] font-black uppercase tracking-widest border-2 
                {{ $product->status == 'active' ? 'bg-green-50 text-green-600 border-green-200' : 'bg-gray-50 text-gray-400 border-gray-200' }}">
                {{ $product->status }}
            </span>

            {{-- BADGE PROMO --}}
            @if($product->is_promo)
            <span class="px-3 py-0.5 rounded-full text-[8px] font-black uppercase tracking-widest bg-yellow-400 text-black border-2 border-black">
                PROMO
            </span>
            @endif
        </div>
        <p class="text-[9px] font-bold text-[#BABABA] uppercase tracking-widest">Database Information System</p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="text-[10px] font-black text-[#BABABA] hover:text-[#202020] uppercase tracking-widest transition-all pb-1 border-b-2 border-transparent hover:border-[#202020]">
        ← Back to Inventory
    </a>
</div>

<div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-8 md:p-12 shadow-sm flex flex-col lg:flex-row gap-16">
    
    <div class="w-full lg:w-5/12">
        <div class="aspect-square bg-[#F9F9F9] rounded-[2rem] flex items-center justify-center p-10 border border-[#BABABA]/10 mb-6">
            @if($product->images->count() > 0)
                <img id="main-product-image" src="{{ Storage::url($product->images->first()->image_path) }}" 
                    class="max-w-full max-h-full object-contain mix-blend-multiply transition-opacity duration-300">
            @else
                <span class="text-[10px] font-black text-[#BABABA] uppercase tracking-[0.4em]">Image Empty</span>
            @endif
        </div>
        
        <div class="flex gap-3 overflow-x-auto pb-4 no-scrollbar">
            @foreach($product->images as $img)
                <div class="w-20 h-20 rounded-2xl border-2 border-transparent hover:border-[#CD2828] overflow-hidden cursor-pointer transition-all bg-[#F9F9F9] flex-shrink-0 shadow-sm">
                    <img src="{{ Storage::url($img->image_path) }}" onclick="changeMainImage(this.src)" class="w-full h-full object-cover">
                </div>
            @endforeach
        </div>
    </div>

    <div class="w-full lg:w-7/12 flex flex-col justify-center">
        <div class="mb-8">
            <div class="flex flex-wrap gap-2 mb-6">
                @foreach($product->categories as $category)
                    <span class="text-[8px] font-black uppercase tracking-widest text-[#BABABA] border border-[#BABABA]/30 px-3 py-1 rounded-lg">
                        {{ $category->name }}
                    </span>
                @endforeach
            </div>
            
            <h2 class="text-2xl font-black text-[#202020] uppercase leading-none tracking-tighter mb-4">{{ $product->name }}</h2>
            <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-[0.3em]">SKU • {{ $product->sku }}</p>
        </div>

        <div class="mb-10">
            @if($product->discount > 0)
                @php $finalPrice = $product->price - ($product->price * $product->discount / 100); @endphp
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-sm text-[#BABABA] line-through font-bold">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                    <span class="bg-[#CD2828] text-[#FEFEFE] text-[9px] font-black px-2 py-0.5 rounded uppercase">
                        SAVE {{ $product->discount }}%
                    </span>
                </div>
                <h3 class="text-xl font-black text-[#CD2828] tracking-tighter">Rp{{ number_format($finalPrice, 0, ',', '.') }}</h3>
            @else
                <h3 class="text-xl font-black text-[#202020] tracking-tighter">Rp{{ number_format($product->price, 0, ',', '.') }}</h3>
            @endif
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 py-8 border-y border-[#BABABA]/10 mb-10 text-center md:text-left">
            <div>
                <p class="text-[8px] font-black text-[#BABABA] uppercase mb-2 tracking-widest">Favorited</p>
                <p class="text-lg font-black text-[#202020]">{{ $product->favoritedBy()->count() }} <span class="text-[9px] text-[#BABABA]">USERS</span></p>
            </div>
            <div>
                <p class="text-[8px] font-black text-[#BABABA] uppercase mb-2 tracking-widest">Weight</p>
                <p class="text-lg font-black text-[#202020]">{{ $product->weight ?? '0' }} <span class="text-[9px] text-[#BABABA]">KG</span></p>
            </div>
            <div>
                <p class="text-[8px] font-black text-[#BABABA] uppercase mb-2 tracking-widest">Sold</p>
                <p class="text-lg font-black text-[#202020]">{{ $product->orderItems()->sum('quantity') }} <span class="text-[9px] text-[#BABABA]">ITEMS</span></p>
            </div>
            <div>
                <p class="text-[8px] font-black text-[#BABABA] uppercase mb-2 tracking-widest">Stock Left</p>
                <p class="text-lg font-black {{ $product->stock <= 5 ? 'text-[#CD2828]' : 'text-[#202020]' }}">
                    {{ $product->stock }} <span class="text-[9px] text-[#BABABA]">UNIT</span>
                </p>
            </div>
        </div>

        <div>
            <h3 class="text-[9px] font-black text-[#BABABA] uppercase mb-4 tracking-[0.3em]">Spesifikasi</h3>
            <div class="text-sm text-[#202020] leading-relaxed whitespace-pre-line bg-[#F9F9F9] p-6 rounded-xl border border-[#BABABA]/20 mb-6">
                {{ $product->description }}

            </div>
            <!-- <p class="text-xs text-gray-600 leading-relaxed whitespace-pre-line bg-gray-50 p-4 rounded-xl border border-gray-100 ">
                {{ $product->description }}
            </p> -->
        </div>
    </div>
</div>

<script>
    function changeMainImage(newSrc) {
        const mainImg = document.getElementById('main-product-image');
        mainImg.style.opacity = '0.3';
        setTimeout(() => {
            mainImg.src = newSrc;
            mainImg.style.opacity = '1';
        }, 150);
    }
</script>
@endsection