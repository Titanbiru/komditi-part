@extends('layouts.staff')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-[#CD2828]">product</h1>
    <div class="flex items-center gap-3">
        <span class="text-gray-700 font-medium">{{ auth()->user()->name }}</span>
        <span class="px-4 py-1 bg-[#832A2A] text-white text-sm rounded-full font-medium">staff</span>
    </div>
</div>

<div class="bg-white rounded-xl shadow-md border border-[#BABABA] overflow-hidden">
    <div class="flex justify-between items-center px-6 py-5 border-b border-[#BABABA]">
        <div class="relative">
            <form action="{{ route('staff.products.index') }}" method="GET">
                <input type="text" name="search" placeholder="search" value="{{ request('search') }}"
                    class="border border-[#BABABA] rounded-full px-4 py-2 text-sm focus:outline-none focus:border-[#CD2828] w-80">
            </form>
            <p class="text-xs text-gray-400 mt-1 ml-4">*find by category using search</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-[#C4C4C4]">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-bold text-black border-r border-white">Product Name</th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-black border-r border-white">SKU</th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-black border-r border-white">Price</th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-black border-r border-white">Stock</th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-black border-r border-white">status</th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-black">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#BABABA]">
                @forelse($products as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900 uppercase font-medium">{{ $p->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $p->sku }}</td>
                        <td class="px-6 py-4">
                            @if($p->discount > 0)
                                @php
                                    // Hitung harga setelah diskon
                                    $finalPrice = $p->price - ($p->price * $p->discount / 100);
                                @endphp
                                
                                <div class="flex flex-col">
                                    {{-- Harga Final (Besar & Tebal) --}}
                                    <span class="text-sm text-gray-900 font-bold">
                                        Rp {{ number_format($finalPrice, 0, ',', '.') }}
                                    </span>
                                    
                                    <div class="flex items-center gap-1">
                                        <span class="text-[10px] text-[#CD2828] font-semibold">
                                            -{{ $p->discount }}%
                                        </span>
                                    </div>
                                </div>
                            @else
                                {{-- Harga Normal (Jika tidak ada diskon) --}}
                                <span class="text-sm text-gray-900 font-bold">
                                    Rp {{ number_format($p->price, 0, ',', '.') }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $p->stock }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="{{ $p->status == 'active' ? 'text-green-500' : 'text-yellow-500' }} font-bold">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('staff.products.show', $p) }}" class="text[#BABABA] hover:underline">Show</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="text-gray-500 font-medium italic">Belum ada product yang terdaftar.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-[#BABABA] bg-gray-50">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
@endsection
