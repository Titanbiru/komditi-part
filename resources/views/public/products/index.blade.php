@extends('layouts.public')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex flex-col md:flex-row gap-8">
        
        <div class="w-full md:w-1/4">
            <div class="bg-white border border-gray-200 rounded-3xl p-6 shadow-sm sticky top-24">
                <h3 class="text-lg font-bold mb-4 pb-2 border-b border-red-500 inline-block text-red-600 uppercase tracking-wider">Kategori</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('public.products') }}" 
                        class="flex items-center gap-3 p-3 rounded-2xl border transition-all duration-300 {{ !isset($currentCategory) ? 'border-red-500 bg-red-50 text-red-600' : 'border-gray-100 hover:border-red-300' }}">
                        <div class="w-3 h-3 rounded-full {{ !isset($currentCategory) ? 'bg-red-600 shadow-[0_0_8px_rgba(220,38,38,0.5)]' : 'bg-gray-300' }}"></div>
                        <span class="font-bold text-sm">Semua Produk</span>
                    </a>

                    @foreach($categories as $cat)
                    <a href="{{ route('public.category', $cat->slug) }}" 
                        class="flex items-center gap-3 p-3 rounded-2xl border transition-all duration-300 {{ isset($currentCategory) && $currentCategory->id == $cat->id ? 'border-red-500 bg-red-50 text-red-600' : 'border-gray-100 hover:border-red-300' }}">
                        
                        <div class="w-3 h-3 rounded-full {{ isset($currentCategory) && $currentCategory->id == $cat->id ? 'bg-red-600 shadow-[0_0_8px_rgba(220,38,38,0.5)]' : 'bg-gray-300' }}"></div>
                        
                        @if($cat->icon)
                            <img src="{{ asset($cat->icon) }}" class="w-5 h-5 object-contain">
                        @endif
                        <span class="font-bold text-sm">{{ $cat->name }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="w-full md:w-3/4">
            <div class="mb-8">
                <h1 class="text-3xl font-black text-gray-800 uppercase italic">
                    @if(isset($currentCategory))
                        Produk <span class="text-red-600">{{ $currentCategory->name }}</span>
                    @else
                        Semua <span class="text-red-600">Produk</span>
                    @endif
                </h1>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($products as $product)
                    @include('components.product-card', ['product' => $product])
                @empty
                    <div class="col-span-full py-20 text-center">
                        <p class="text-gray-400 font-bold uppercase tracking-widest">Maaf, Produk belum tersedia.</p>
                    </div>
                @endforelse
            </div>
    
            <div class="mt-12 flex justify-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection