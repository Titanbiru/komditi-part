@extends('layouts.admin')

@section('content')
<form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" id="productForm" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($product)) @method('PUT') @endif

    <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 px-2">
        <div>
            <h1 class="text-3xl font-black text-[#CD2828] uppercase tracking-tighter">
                {{ isset($product) ? 'Modify Product' : 'Add New Entry' }}
            </h1>
            <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Configure item specifications & gallery</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.products.index') }}" class="bg-[#F9F9F9] text-[#BABABA] px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#202020] hover:text-white transition-all">Back</a>
            <button type="submit" onclick="submitProductForm()" class="bg-[#CD2828] text-white px-10 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#202020] transition-all shadow-lg active:scale-95">
                {{ isset($product) ? 'Update Records' : 'Save Product' }}
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 pb-20">
        <div class="lg:col-span-2 space-y-6">
            {{-- DATA UTAMA --}}
            <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-8 shadow-sm space-y-6">
                <div>
                    <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Product Identity</label>
                    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required 
                        class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-4 text-[11px] font-black uppercase text-[#202020] outline-none focus:ring-1 focus:ring-[#CD2828]">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">SKU / Code</label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" required 
                            class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-4 text-[11px] font-black text-[#202020] outline-none">
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Weight (KG)</label>
                        <input type="text" name="weight" value="{{ old('weight', $product->weight ?? '') }}" placeholder="0.5" 
                            class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-4 text-[11px] font-black text-[#202020] outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Base Price (IDR)</label>
                        <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}" required 
                            class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-4 text-[11px] font-black text-[#202020] outline-none">
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Discount (%)</label>
                        <input type="number" name="discount" value="{{ old('discount', $product->discount ?? 0) }}" 
                            class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-4 text-[11px] font-black text-[#CD2828] outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Description</label>
                    <textarea name="description" rows="4" class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-4 text-[11px] font-medium text-[#202020] outline-none focus:ring-1 focus:ring-[#CD2828]">{{ old('description', $product->description ?? '') }}</textarea>
                </div>
            </div>

            {{-- CATEGORY SELECTION --}}
            <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-8 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <label class="block text-[9px] font-black text-[#BABABA] uppercase tracking-widest ml-1">Classification Categories</label>
                    <span class="text-[8px] font-bold text-[#BABABA] uppercase">Scroll to explore</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-[220px] overflow-y-auto custom-scrollbar pr-2">
                    @foreach($categories as $cat)
                        <label class="flex items-center gap-3 p-4 rounded-2xl border border-[#BABABA]/5 bg-[#F9F9F9] hover:bg-red-50 cursor-pointer transition-all group has-[:checked]:bg-[#202020] has-[:checked]:text-white">
                            <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}" 
                                {{ (isset($product) && $product->categories->contains($cat->id)) ? 'checked' : '' }}
                                class="hidden">
                            <span class="text-[10px] font-black uppercase tracking-tight group-hover:text-[#CD2828] group-has-[:checked]:text-[#1BCFD5]">
                                {{ $cat->name }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- SIDEBAR: IMAGES & STATUS --}}
        <div class="space-y-6">
            <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-8 shadow-sm space-y-6">
                <div>
                    <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-4 ml-1 tracking-widest">Inventory Status</label>
                    <div class="flex flex-col gap-2">
                        <label class="flex items-center gap-3 p-4 rounded-2xl bg-[#F9F9F9] cursor-pointer has-[:checked]:bg-[#1BCFD5] has-[:checked]:text-white transition-all">
                            <input type="radio" name="status" value="active" class="hidden" {{ (old('status', $product->status ?? 'active') == 'active') ? 'checked' : '' }}>
                            <span class="text-[10px] font-black uppercase tracking-widest">Active Stock</span>
                        </label>
                        <label class="flex items-center gap-3 p-4 rounded-2xl bg-[#F9F9F9] cursor-pointer has-[:checked]:bg-[#CD2828] has-[:checked]:text-white transition-all">
                            <input type="radio" name="status" value="inactive" class="hidden" {{ (old('status', $product->status ?? '') == 'inactive') ? 'checked' : '' }}>
                            <span class="text-[10px] font-black uppercase tracking-widest">Draft / Hide</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Stock Units</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock ?? '') }}" required 
                        class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-4 text-[11px] font-black text-[#202020] outline-none">
                </div>
            </div>

            {{-- GALLERY --}}
            <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-8 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <label class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest ml-1">Asset Gallery</label>
                    <label for="multi_image_input" class="cursor-pointer bg-[#F9F9F9] text-[#202020] p-2 rounded-xl hover:bg-[#CD2828] hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                        <input type="file" name="images[]" id="multi_image_input" class="hidden" accept="image/*" multiple onchange="handleMultipleFiles(this)">
                    </label>
                </div>
                
                <div id="gallery_preview_container" class="grid grid-cols-2 gap-2 min-h-[120px] border-2 border-dashed border-[#BABABA]/10 rounded-2xl p-2 bg-[#F9F9F9] mb-4">
                    <div id="gallery_empty_msg" class="col-span-2 flex flex-col items-center justify-center py-6 text-[#BABABA]">
                        <p class="text-[8px] font-black uppercase">No New Uploads</p>
                    </div>
                </div>

                @if(isset($product) && $product->images->count() > 0)
                <div class="space-y-2">
                    <p class="text-[8px] font-black text-[#BABABA] uppercase tracking-widest ml-1">Existing Assets</p>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach($product->images as $img)
                            <div class="relative aspect-square rounded-xl bg-[#F9F9F9] overflow-hidden group" id="old-image-{{ $img->id }}">
                                <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover">
                                <button type="button" onclick="deleteExistingImage({{ $img->id }})" class="absolute inset-0 bg-[#CD2828]/80 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</form>

{{-- MODAL ZOOM --}}
<div id="image_zoom_modal" class="hidden fixed inset-0 bg-[#202020]/95 z-[999] flex items-center justify-center p-8 animate-fade-in" onclick="closeZoomModal()">
    <img id="zoomed_image_src" src="" class="max-w-full max-h-full object-contain rounded-3xl shadow-2xl">
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f9f9f9; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #CD2828; border-radius: 10px; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .animate-fade-in { animation: fadeIn 0.3s ease-out; }
</style>
@endsection