@extends('layouts.user')

@section('content')
<div class="py-4">
    {{-- Card Utama dengan Border & Shadow Halus --}}
    <div class="bg-white border-2 border-gray-50 rounded-[2.5rem] p-8 shadow-xl shadow-gray-100/50">
        
        {{-- Header Form dengan Tombol Back yang Pop --}}
        <div class="flex items-center gap-5 mb-10">
            <a href="{{ route('user.account.addresses') }}" 
               class="group p-3 bg-gray-50 rounded-2xl hover:bg-[#CD2828] transition-all duration-300 shadow-sm">
                <svg class="w-6 h-6 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M15 19l-7-7 7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <div>
                <h3 class="text-xl font-black text-gray-900 uppercase italic tracking-tighter leading-none">Tambah Alamat Baru</h3>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Pastikan data pengiriman sudah benar</p>
            </div>
        </div>

        <form action="{{ route('user.account.addresses.store') }}" method="POST" class="space-y-8">
            @csrf
            
            {{-- Pilihan Tipe Alamat --}}
            <div class="space-y-4">
                <label class="flex items-center gap-2 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">
                    <span class="w-2 h-2 bg-cyan-400 rounded-full"></span> Tipe Alamat
                </label>
                <div class="flex flex-wrap gap-3">
                    @foreach(['Rumah', 'Kantor', 'Apartemen', 'Kos'] as $label)
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="{{ $label }}" class="hidden peer" 
                                {{ (old('type') == $label || ($loop->first && !old('type'))) ? 'checked' : '' }}>
                            <div class="px-8 py-3 rounded-2xl border-2 border-gray-100 text-xs font-black uppercase tracking-widest transition-all duration-300
                                peer-checked:bg-black peer-checked:text-white peer-checked:border-black text-gray-400 hover:border-gray-300 bg-white shadow-sm">
                                {{ $label }}
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
            
            {{-- Nama & Telepon --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Nama Penerima --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Nama Penerima</label>
                    <input type="text" name="recipient_name" placeholder="Contoh: Budi Sudarsono" 
                        class="w-full bg-gray-50/50 border-2 border-gray-100 rounded-[1.5rem] px-6 py-4 text-sm font-bold focus:outline-none focus:border-cyan-400 focus:bg-white transition-all @error('recipient_name') border-red-500 @enderror" value="{{ old('recipient_name') }}">
                    @error('recipient_name') <p class="text-[9px] text-red-500 font-bold uppercase mt-1 ml-4 italic">{{ $message }}</p> @enderror
                </div>

                {{-- Nomor Telepon --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Nomor Telepon</label>
                    <input type="text" name="phone" placeholder="0857xxxxxxxx" 
                        class="w-full bg-gray-50/50 border-2 border-gray-100 rounded-[1.5rem] px-6 py-4 text-sm font-bold focus:outline-none focus:border-cyan-400 focus:bg-white transition-all @error('phone') border-red-500 @enderror" value="{{ old('phone') }}">
                    @error('phone') <p class="text-[9px] text-red-500 font-bold uppercase mt-1 ml-4 italic">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Alamat Lengkap --}}
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Alamat Lengkap</label>
                <textarea name="address" rows="3" placeholder="Nama Jalan, No. Rumah, Komplek, dll." 
                    class="w-full bg-gray-50/50 border-2 border-gray-100 rounded-[1.5rem] px-6 py-4 text-sm font-bold focus:outline-none focus:border-cyan-400 focus:bg-white transition-all resize-none @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                @error('address') <p class="text-[9px] text-red-500 font-bold uppercase mt-1 ml-4 italic">{{ $message }}</p> @enderror
            </div>

            {{-- Wilayah --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Provinsi</label>
                    <input type="text" name="province" placeholder="Jawa Barat" 
                        class="w-full bg-gray-50/50 border-2 border-gray-100 rounded-[1.5rem] px-6 py-4 text-sm font-bold focus:outline-none focus:border-cyan-400 focus:bg-white transition-all @error('province') border-red-500 @enderror" value="{{ old('province') }}">
                    @error('province') <p class="text-[9px] text-red-500 font-bold uppercase mt-1 ml-4 italic">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Kota / Kabupaten</label>
                    <input type="text" name="city" placeholder="Bandung" 
                        class="w-full bg-gray-50/50 border-2 border-gray-100 rounded-[1.5rem] px-6 py-4 text-sm font-bold focus:outline-none focus:border-cyan-400 focus:bg-white transition-all @error('city') border-red-500 @enderror" value="{{ old('city') }}">
                    @error('city') <p class="text-[9px] text-red-500 font-bold uppercase mt-1 ml-4 italic">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Kode Pos</label>
                    <input type="text" name="postal_code" placeholder="40xxx" 
                        class="w-full bg-gray-50/50 border-2 border-gray-100 rounded-[1.5rem] px-6 py-4 text-sm font-bold focus:outline-none focus:border-cyan-400 focus:bg-white transition-all @error('postal_code') border-red-500 @enderror" value="{{ old('postal_code') }}">
                    @error('postal_code') <p class="text-[9px] text-red-500 font-bold uppercase mt-1 ml-4 italic">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Checkbox Default --}}
            <div class="flex items-center gap-4 px-6 py-4 bg-gray-50 rounded-[1.5rem] border-2 border-dashed border-gray-200">
                <input type="checkbox" name="is_default" id="is_default" value="1" {{ old('is_default') ? 'checked' : '' }} 
                    class="w-5 h-5 accent-cyan-400 cursor-pointer rounded-lg">
                <label for="is_default" class="text-[10px] font-black text-gray-600 uppercase tracking-widest cursor-pointer select-none">
                    Jadikan Alamat Utama untuk Pengiriman
                </label>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex flex-col md:flex-row justify-end gap-4 pt-6">
                <a href="{{ route('user.account.addresses') }}" class="px-10 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest text-gray-400 text-center hover:text-black transition-all">
                    Batal
                </a>
                <button type="submit" class="bg-[#CD2828] text-white px-12 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-black transition-all shadow-xl shadow-red-100">
                    Simpan Alamat
                </button>
            </div>
        </form>
    </div>
</div>
@endsection