@extends('layouts.staff')

@section('content')
<div class="max-w-4xl">
    <h1 class="text-3xl font-bold text-black mb-8">Update Stock</h1>

    <div class="space-y-1 mb-8">
        <p class="text-xl font-bold"><span class="uppercase">product name:</span> {{ $product->name }}</p>
        <p class="text-xl font-bold"><span class="uppercase">SKU:</span> {{ $product->sku }}</p>
        <p class="text-xl font-bold">Current Stocks: {{ $product->stock }}</p>
        <p class="text-xl font-bold">Minimum Stocks: 10</p>
        <p class="text-xl font-bold">Status Stocks: 
            <span class="{{ $product->stock < 10 ? 'text-yellow-500' : 'text-green-500' }}">
                {{ $product->stock < 10 ? 'running low' : 'safe' }}
            </span>
        </p>
    </div>

    <form action="{{ route('staff.stock.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-6">
            <h3 class="font-bold text-xl mb-3">Type of changes</h3>
            <div class="flex gap-4">
                <label class="flex items-center gap-2 border-2 border-gray-300 rounded-full px-6 py-2 cursor-pointer has-[:checked]:border-red-500 transition-all bg-white">
                    <input type="radio" name="type" value="in" checked class="accent-red-600 w-4 h-4">
                    <span class="text-lg font-medium">Incoming Stocks</span>
                </label>
                <label class="flex items-center gap-2 border-2 border-gray-300 rounded-full px-6 py-2 cursor-pointer has-[:checked]:border-red-500 transition-all bg-white">
                    <input type="radio" name="type" value="out" class="accent-red-600 w-4 h-4">
                    <span class="text-lg font-medium">Out of Stocks</span>
                </label>
            </div>
        </div>

        <div class="mb-6 max-w-xs">
            <h3 class="font-bold text-xl mb-1">Amount of Changes</h3>
            <p class="text-[10px] text-gray-400 italic mb-2">*cannot below zero</p>
            <input type="number" name="amount" required min="1" placeholder="12"
                class="w-full border-2 border-gray-300 rounded-2xl px-6 py-3 text-lg font-bold focus:outline-none focus:border-red-500">
        </div>

        <div class="mb-8">
            <h3 class="font-bold text-xl mb-1">Noted</h3>
            <p class="text-[10px] text-gray-400 italic mb-2">*Restock from supplier A / broken items / adjusment</p>
            <textarea name="note" rows="4" placeholder="restock"
                class="w-full border-2 border-gray-300 rounded-2xl px-6 py-4 text-lg focus:outline-none focus:border-red-500"></textarea>
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('staff.stock.index') }}" class="px-10 py-2 bg-[#BABABA] text-black font-bold rounded-full hover:bg-gray-400 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Back
            </a>
            <button type="submit" class="px-10 py-2 bg-[#1BCFD5] text-white font-bold rounded-full hover:opacity-90 shadow-lg">
                Saved Changes
            </button>
        </div>
    </form>
</div>
@endsection