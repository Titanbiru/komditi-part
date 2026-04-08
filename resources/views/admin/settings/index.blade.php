@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto pb-20">
    {{-- HEADER --}}
    <div class="mb-10 px-2">
        <h1 class="text-3xl font-black text-[#CD2828] uppercase tracking-tighter">Store Configuration</h1>
        <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Manage Banners, Payments, and Shop Assets</p>
    </div>

    <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-10 shadow-sm">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-12">
            @csrf
            @method('PUT')

            {{-- SECTION 1: PROMOTION BANNERS --}}
            <div class="space-y-6">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-1 h-4 bg-[#CD2828] rounded-full"></span>
                    <h3 class="text-[11px] font-black text-[#202020] uppercase tracking-[0.2em]">Promotion Banners (Homepage)</h3>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {{-- Banner Utama --}}
                    <div class="space-y-4">
                        <label class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest ml-1">Primary Banner (Large)</label>
                        <div class="aspect-video bg-[#F9F9F9] rounded-2xl overflow-hidden border border-[#BABABA]/10 group relative">
                            <img id="preview-hero" src="{{ Storage::url(get_setting('hero_image')) }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all">
                            <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-all"></div>
                        </div>
                        <input type="file" name="hero_image" onchange="previewImg(this, 'preview-hero')" 
                            class="text-[9px] font-black uppercase w-full file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[9px] file:font-black file:bg-[#202020] file:text-white hover:file:bg-[#CD2828] transition-all cursor-pointer">
                    </div>

                    {{-- Banner Samping 1 --}}
                    <div class="space-y-4">
                        <label class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest ml-1">Side Banner (Top)</label>
                        <div class="aspect-video bg-[#F9F9F9] rounded-2xl overflow-hidden border border-[#BABABA]/10 group relative">
                            <img id="preview-side-1" src="{{ Storage::url(get_setting('hero_side_1')) }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all">
                        </div>
                        <input type="file" name="hero_side_1" onchange="previewImg(this, 'preview-side-1')" 
                            class="text-[9px] font-black uppercase w-full file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[9px] file:font-black file:bg-[#202020] file:text-white hover:file:bg-[#CD2828] transition-all cursor-pointer">
                    </div>

                    {{-- Banner Samping 2 --}}
                    <div class="space-y-4">
                        <label class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest ml-1">Side Banner (Bottom)</label>
                        <div class="aspect-video bg-[#F9F9F9] rounded-2xl overflow-hidden border border-[#BABABA]/10 group relative">
                            <img id="preview-side-2" src="{{ Storage::url(get_setting('hero_side_2')) }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all">
                        </div>
                        <input type="file" name="hero_side_2" onchange="previewImg(this, 'preview-side-2')" 
                            class="text-[9px] font-black uppercase w-full file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[9px] file:font-black file:bg-[#202020] file:text-white hover:file:bg-[#CD2828] transition-all cursor-pointer">
                    </div>
                </div>
            </div>

            <hr class="border-[#BABABA]/10">

            {{-- SECTION 2: PAYMENT GATEWAY --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                {{-- Bank Accounts --}}
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <span class="w-1 h-4 bg-[#CD2828] rounded-full"></span>
                        <h3 class="text-[11px] font-black text-[#202020] uppercase tracking-[0.2em]">Bank Accounts</h3>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="text-[8px] font-black text-[#BABABA] uppercase tracking-widest ml-1 mb-1 block">Provider Name</label>
                            <input type="text" name="bank_name" value="{{ get_setting('bank_name') }}" placeholder="E.G. BANK BCA" 
                                class="w-full bg-[#F9F9F9] border-none rounded-xl px-5 py-3.5 text-[11px] font-black text-[#202020] outline-none uppercase tracking-widest focus:ring-1 focus:ring-[#CD2828]">
                        </div>
                        <div>
                            <label class="text-[8px] font-black text-[#BABABA] uppercase tracking-widest ml-1 mb-1 block">Account Number</label>
                            <input type="text" name="bank_account" value="{{ get_setting('bank_account') }}" placeholder="882103xxx" 
                                class="w-full bg-[#F9F9F9] border-none rounded-xl px-5 py-3.5 text-[11px] font-black text-[#202020] outline-none">
                        </div>
                        <div>
                            <label class="text-[8px] font-black text-[#BABABA] uppercase tracking-widest ml-1 mb-1 block">Account Holder</label>
                            <input type="text" name="bank_holder" value="{{ get_setting('bank_holder') }}" placeholder="A/N KOMDITI" 
                                class="w-full bg-[#F9F9F9] border-none rounded-xl px-5 py-3.5 text-[11px] font-black text-[#202020] outline-none uppercase tracking-widest">
                        </div>
                    </div>
                </div>

                {{-- QRIS --}}
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <span class="w-1 h-4 bg-[#1BCFD5] rounded-full"></span>
                        <h3 class="text-[11px] font-black text-[#202020] uppercase tracking-[0.2em]">QRIS Merchant</h3>
                    </div>
                    <div class="flex flex-col items-center gap-6 bg-[#F9F9F9] p-8 rounded-[2rem] border border-dashed border-[#BABABA]/20">
                        <div class="w-32 h-32 bg-white p-3 rounded-2xl shadow-sm border border-[#BABABA]/5 relative group">
                            <img id="preview-qris" src="{{ Storage::url(get_setting('qris_image')) }}" class="w-full h-full object-contain mix-blend-multiply grayscale group-hover:grayscale-0 transition-all">
                        </div>
                        <input type="file" name="qris_image" onchange="previewImg(this, 'preview-qris')" 
                            class="text-[9px] font-black uppercase w-full file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[9px] file:font-black file:bg-[#1BCFD5] file:text-white hover:file:bg-[#202020] transition-all cursor-pointer">
                    </div>
                </div>
            </div>

            {{-- SECTION 3: LOCATION --}}
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <span class="w-1 h-4 bg-[#BABABA] rounded-full"></span>
                    <h3 class="text-[11px] font-black text-[#202020] uppercase tracking-[0.2em]">Store Location</h3>
                </div>
                <textarea name="shop_address" rows="3" placeholder="FULL STORE ADDRESS..." 
                    class="w-full bg-[#F9F9F9] border-none rounded-[2rem] px-8 py-6 text-[11px] font-bold text-[#202020] outline-none focus:ring-1 focus:ring-[#CD2828] uppercase leading-relaxed">{{ get_setting('shop_address') }}</textarea>
            </div>

            <div class="flex justify-end pt-6">
                <button type="submit" class="bg-[#202020] text-white px-12 py-4 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-[#CD2828] transition-all shadow-lg active:scale-95">
                    Save Configuration
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImg(input, targetId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(targetId).src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection