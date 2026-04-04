@extends('layouts.public')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        
        {{-- SIDEBAR KIRI --}}
        <div class="w-full lg:w-1/4">
            <div class="bg-white border border-gray-100 rounded-[2rem] p-6 shadow-sm space-y-6">
                <div class="px-2">
                    <h2 class="text-sm font-bold text-gray-400 italic">Hello, <span class="text-[#CD2828]">{{ Auth::user()->name }}!</span></h2>
                </div>

                <div class="flex flex-col gap-2">
                    <a href="{{ route('user.settings') }}" class="flex items-center gap-4 bg-[#CD2828] text-white px-6 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-lg shadow-red-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-width="2"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/></svg>
                        Pengaturan
                    </a>

                    <a href="#" class="flex items-center gap-4 text-gray-500 hover:bg-gray-50 px-6 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest transition-all border border-transparent hover:border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/></svg>
                        Alamat
                    </a>

                    <a href="#" class="flex items-center gap-4 text-gray-500 hover:bg-gray-50 px-6 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest transition-all border border-transparent hover:border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                        Riwayat Pesanan
                    </a>

                    <a href="#" class="flex items-center gap-4 text-gray-500 hover:bg-gray-50 px-6 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest transition-all border border-transparent hover:border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" stroke-width="2"/></svg>
                        Produk Saya
                    </a>
                </div>

                <div class="pt-10">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full bg-gray-300 text-gray-600 py-3 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-red-600 hover:text-white transition-all shadow-md active:scale-95">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- CONTENT KANAN --}}
        <div class="w-full lg:w-3/4 space-y-8">
            {{-- Bagian Profil --}}
            <div class="bg-white border border-gray-100 rounded-[2.5rem] p-8 shadow-sm">
                <h3 class="text-sm font-black text-gray-800 uppercase italic tracking-widest mb-8">Informasi Akun</h3>
                
                <form action="{{ route('user.update.profile') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-4">Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="w-full bg-white border border-gray-200 rounded-2xl px-6 py-3 text-sm focus:outline-none focus:border-cyan-400">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-4">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="w-full bg-white border border-gray-200 rounded-2xl px-6 py-3 text-sm focus:outline-none focus:border-cyan-400">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-4">No Telp</label>
                        <input type="text" name="phone" value="{{ $user->phone ?? '0857xxxxxxxxx' }}" class="w-full bg-white border border-gray-200 rounded-2xl px-6 py-3 text-sm focus:outline-none focus:border-cyan-400">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-cyan-400 text-white px-10 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-black transition-all shadow-lg shadow-cyan-100">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Bagian Password --}}
            <div class="bg-white border border-gray-100 rounded-[2.5rem] p-8 shadow-sm">
                <h3 class="text-sm font-black text-gray-800 uppercase italic tracking-widest mb-8">Ubah Password</h3>
                
                <form action="{{ route('user.update.password') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-4">Password</label>
                        <input type="password" name="password" class="w-full bg-white border border-gray-200 rounded-2xl px-6 py-3 text-sm focus:outline-none focus:border-cyan-400">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-4">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="w-full bg-white border border-gray-200 rounded-2xl px-6 py-3 text-sm focus:outline-none focus:border-cyan-400">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-cyan-400 text-white px-10 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-black transition-all shadow-lg shadow-cyan-100">
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection