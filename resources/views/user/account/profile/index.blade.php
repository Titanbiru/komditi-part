@extends('layouts.user')

@section('content')

{{-- NAVIGASI BAWAH MOBILE --}}
<div class="lg:hidden fixed bottom-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-xl border-t border-gray-100 px-2 py-3 shadow-[0_-15px_30px_rgba(0,0,0,0,0.08)] rounded-t-[2.5rem]">
    <div class="flex justify-around items-end"> {{-- Pakai items-end biar tombol tengah terlihat pas --}}
        
        {{-- Profile --}}
        <a href="{{ route('user.account.profile') }}" 
           class="flex flex-col items-center gap-1 group transition-all duration-300 {{ request()->routeIs('user.account.profile') ? 'scale-110' : '' }}">
            <div class="p-2 rounded-2xl transition-all {{ request()->routeIs('user.account.profile') ? 'bg-[#CD2828]/10 text-[#CD2828]' : 'text-gray-400' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-width="2.5"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2.5"/></svg>
            </div>
            <span class="text-[7px] font-black uppercase tracking-tighter {{ request()->routeIs('user.account.profile') ? 'text-[#CD2828]' : 'text-gray-400' }}">Profil</span>
        </a>

        {{-- Alamat --}}
        <a href="{{ route('user.account.addresses') }}" 
           class="flex flex-col items-center gap-1 group transition-all duration-300 {{ request()->routeIs('user.account.addresses*') ? 'scale-110' : '' }}">
            <div class="p-2 rounded-2xl transition-all {{ request()->routeIs('user.account.addresses*') ? 'bg-[#CD2828]/10 text-[#CD2828]' : 'text-gray-400' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2.5"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2.5"/></svg>
            </div>
            <span class="text-[7px] font-black uppercase tracking-tighter {{ request()->routeIs('user.account.addresses*') ? 'text-[#CD2828]' : 'text-gray-400' }}">Alamat</span>
        </a>

        {{-- PESANAN (Highlight Tengah) --}}
        <a href="{{ route('user.account.orders') }}" 
           class="flex flex-col items-center relative -top-4">
            <div class="p-4 rounded-full shadow-2xl transition-all duration-500 {{ request()->routeIs('user.account.orders*') ? 'bg-[#CD2828] text-white ring-8 ring-red-50' : 'bg-[#202020] text-white hover:bg-[#CD2828]' }}">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2.5"/></svg>
            </div>
            <span class="text-[7px] font-black uppercase tracking-tighter mt-1 {{ request()->routeIs('user.account.orders*') ? 'text-[#CD2828]' : 'text-gray-400' }}">Pesanan</span>
        </a>

        {{-- Produk Saya --}}
        <a href="{{ route('user.account.favorites') }}" 
           class="flex flex-col items-center gap-1 group transition-all duration-300 {{ request()->routeIs('user.account.favorites*') ? 'scale-110' : '' }}">
            <div class="p-2 rounded-2xl transition-all {{ request()->routeIs('user.account.favorites*') ? 'bg-[#CD2828]/10 text-[#CD2828]' : 'text-gray-400' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" stroke-width="2.5"/></svg>
            </div>
            <span class="text-[7px] font-black uppercase tracking-tighter {{ request()->routeIs('user.account.favorites*') ? 'text-[#CD2828]' : 'text-gray-400' }}">Koleksi</span>
        </a>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}" class="flex flex-col items-center">
            @csrf
            <button type="submit" class="p-2 rounded-2xl text-gray-400 hover:bg-gray-100 transition-all flex flex-col items-center gap-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-width="2.5"/></svg>
                <span class="text-[7px] font-black uppercase tracking-tighter">Keluar</span>
            </button>
        </form>

    </div>
</div>

<div class="container mx-auto px-4 ">
    <div class="flex flex-col lg:flex-row gap-8">
        {{-- CONTENT KANAN --}}
        <div class="w-full lg:w-3/4 space-y-8">
            {{-- Bagian Profil --}}
            <div class="bg-white border border-gray-100 rounded-[2.5rem] p-8 shadow-sm">
                <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest mb-8">Informasi Akun</h3>
                
                <form action="{{ route('user.account.profile.update') }}" method="POST" class="space-y-6">
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
                <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest mb-8">Ubah Password</h3>
                
                <form action="{{ route('user.account.profile.update.password') }}" method="POST" class="space-y-6">
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
            
            <div class="bg-red-50/50 border-2 border-dashed border-red-200 rounded-[2.5rem] p-8 mt-12">
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-red-100 text-red-600 rounded-2xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 17c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-red-600 uppercase tracking-widest">Zona Bahaya</h3>
                        <p class="text-[10px] font-bold text-red-400 uppercase mt-1 leading-relaxed">
                            Setelah akun dihapus, semua data pesanan, alamat, dan koleksi Anda akan hilang permanen. Tindakan ini tidak dapat dibatalkan.
                        </p>
                    </div>
                </div>
                
                <div class="mt-8 flex justify-end">
                    <form id="deleteAccountForm" action="{{ route('user.account.profile.delete') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete()" class="bg-[#CD2828] text-white px-10 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-black transition-all shadow-lg shadow-red-100">
                            Hapus Akun Permanen
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function confirmDelete() {
        if (confirm('APAKAH ANDA YAKIN? Semua data akan dihapus permanen dan Anda akan dikeluarkan dari sistem.')) {
            document.getElementById('deleteAccountForm').submit();
        }
    }
</script>
@endsection