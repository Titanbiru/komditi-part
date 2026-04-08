@extends('layouts.staff')

@section('content')
<div class="max-w-3xl">
    <div class="mb-10 px-2">
        <h1 class="text-3xl font-black text-[#202020] uppercase tracking-tighter">Adjust Inventory</h1>
        <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Manual Stock Correction</p>
    </div>

    <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-8 md:p-12 shadow-sm mb-10">
        <div class="grid grid-cols-2 gap-8 mb-10 pb-8 border-b border-[#F9F9F9]">
            <div>
                <p class="text-[8px] font-black text-[#BABABA] uppercase tracking-[0.2em] mb-1">Product Identity</p>
                <p class="text-sm font-black text-[#202020] uppercase">{{ $product->name }}</p>
                <p class="text-[10px] font-bold text-[#BABABA] uppercase mt-1">SKU • {{ $product->sku }}</p>
            </div>
            <div>
                <p class="text-[8px] font-black text-[#BABABA] uppercase tracking-[0.2em] mb-1">Current Balance</p>
                <p class="text-2xl font-black {{ $product->stock < 10 ? 'text-[#CD2828]' : 'text-[#202020]' }}">{{ $product->stock }} <span class="text-[10px] text-[#BABABA]">UNIT</span></p>
            </div>
        </div>

        <form action="{{ route('staff.stock.update', $product->id) }}" method="POST" class="space-y-10">
            @csrf @method('PUT')
            
            <div>
                <h3 class="text-[10px] font-black text-[#BABABA] uppercase tracking-widest mb-4">Transaction Type</h3>
                <div class="flex gap-4">
                    <label class="flex-1 cursor-pointer group">
                        <input type="radio" name="type" value="in" checked class="hidden peer">
                        <div class="p-4 border-2 border-[#F9F9F9] rounded-2xl text-center transition-all peer-checked:border-[#1BCFD5] peer-checked:bg-green-50">
                            <p class="text-[11px] font-black uppercase text-[#BABABA] peer-checked:text-[#1BCFD5]">Incoming Stock</p>
                        </div>
                    </label>
                    <label class="flex-1 cursor-pointer group">
                        <input type="radio" name="type" value="out" class="hidden peer">
                        <div class="p-4 border-2 border-[#F9F9F9] rounded-2xl text-center transition-all peer-checked:border-[#CD2828] peer-checked:bg-red-50">
                            <p class="text-[11px] font-black uppercase text-[#BABABA] peer-checked:text-[#CD2828]">Outgoing Stock</p>
                        </div>
                    </label>
                </div>
            </div>

            <div class="max-w-xs">
                <h3 class="text-[10px] font-black text-[#BABABA] uppercase tracking-widest mb-2">Quantity Adjustment</h3>
                <input type="number" name="amount" required min="1" placeholder="00"
                    class="w-full bg-[#F9F9F9] border-2 border-transparent rounded-2xl px-6 py-4 text-xl font-black focus:outline-none focus:border-[#202020] transition-all">
            </div>

            <div>
                <h3 class="text-[10px] font-black text-[#BABABA] uppercase tracking-widest mb-2">Internal Note</h3>
                <textarea name="note" rows="3" placeholder="REASON FOR ADJUSTMENT..."
                    class="w-full bg-[#F9F9F9] border-2 border-transparent rounded-2xl px-6 py-4 text-xs font-bold uppercase focus:outline-none focus:border-[#202020] transition-all"></textarea>
            </div>

            <div class="flex items-center justify-between pt-6">
                <a href="{{ route('staff.stock.index') }}" class="text-[10px] font-black text-[#BABABA] uppercase tracking-widest hover:text-[#202020] transition-all">Discard</a>
                <button type="submit" class="bg-[#202020] text-[#FEFEFE] px-10 py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-[#CD2828] transition-all shadow-lg">
                    Confirm Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection