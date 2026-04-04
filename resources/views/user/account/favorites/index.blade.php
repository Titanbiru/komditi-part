@extends('layouts.user')

@section('content')
<div class="bg-white border border-gray-100 rounded-[2.5rem] p-8 shadow-sm">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-sm font-black text-gray-800 uppercase italic tracking-widest">Produk Saya</h3>
            <p class="text-[10px] font-bold text-gray-400 uppercase italic tracking-tight">Koleksi barang impian kamu</p>
        </div>
        <span class="bg-red-50 text-[#CD2828] px-4 py-1 rounded-full text-[10px] font-black uppercase italic">
            {{ $favorites->total() }} Item
        </span>
    </div>

    @if($favorites->isEmpty())
        {{-- Tampilan jika kosong --}}
        <div class="py-20 text-center space-y-4">
            <div class="bg-gray-50 text-gray-300 w-fit mx-auto p-6 rounded-full">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" stroke-width="2"/></svg>
            </div>
            <p class="text-gray-400 font-bold italic uppercase text-xs">Belum ada produk favorit</p>
            <a href="{{ route('public.products') }}" class="inline-block text-cyan-400 font-black text-[10px] uppercase underline">Cari Produk Sekarang</a>
        </div>
    @else
        {{-- Grid Produk Favorit --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($favorites as $product)
                {{-- Panggil component kartu di sini --}}
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $favorites->links() }}
        </div>
    @endif
</div>
@endsection