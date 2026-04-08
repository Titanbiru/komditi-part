{{-- NAVIGASI BAWAH MOBILE --}}
<div class="lg:hidden fixed bottom-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-xl border-t border-gray-100 px-2 py-3 shadow-[0_-15px_30px_rgba(0,0,0,0,0.08)] rounded-t-[2.5rem]">
    <div class="flex justify-around items-end"> {{-- Pakai items-end biar tombol tengah terlihat pas --}}
        
        {{-- Profile --}}
        <a href="{{ route('user.account.profile') }}" 
           class="flex flex-col items-center gap-1 group transition-all duration-300 {{ request()->routeIs('user.account.profile') ? 'scale-110' : '' }}">
            <div class="p-2 rounded-2xl transition-all {{ request()->routeIs('user.account.profile') ? 'bg-[#CD2828]/10 text-[#CD2828]' : 'text-gray-400' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-width="2.5"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2.5"/></svg>
            </div>
            <span class="text-[9px] font-black uppercase tracking-tighter {{ request()->routeIs('user.account.profile') ? 'text-[#CD2828]' : 'text-gray-400' }}">Profil</span>
        </a>

        {{-- Alamat --}}
        <a href="{{ route('user.account.addresses') }}" 
           class="flex flex-col items-center gap-1 group transition-all duration-300 {{ request()->routeIs('user.account.addresses*') ? 'scale-110' : '' }}">
            <div class="p-2 rounded-2xl transition-all {{ request()->routeIs('user.account.addresses*') ? 'bg-[#CD2828]/10 text-[#CD2828]' : 'text-gray-400' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2.5"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2.5"/></svg>
            </div>
            <span class="text-[9px] font-black uppercase tracking-tighter {{ request()->routeIs('user.account.addresses*') ? 'text-[#CD2828]' : 'text-gray-400' }}">Alamat</span>
        </a>

        {{-- PESANAN (Highlight Tengah) --}}
        <a href="{{ route('user.account.orders') }}" 
           class="flex flex-col items-center relative -top-4">
            <div class="p-4 rounded-full shadow-2xl transition-all duration-500 {{ request()->routeIs('user.account.orders*') ? 'bg-[#CD2828] text-white ring-8 ring-red-50' : 'bg-[#202020] text-white hover:bg-[#CD2828]' }}">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2.5"/></svg>
            </div>
            <span class="text-[9px] font-black uppercase tracking-tighter mt-1 {{ request()->routeIs('user.account.orders*') ? 'text-[#CD2828]' : 'text-gray-400' }}">Pesanan</span>
        </a>

        {{-- Produk Saya --}}
        <a href="{{ route('user.account.favorites') }}" 
           class="flex flex-col items-center gap-1 group transition-all duration-300 {{ request()->routeIs('user.account.favorites*') ? 'scale-110' : '' }}">
            <div class="p-2 rounded-2xl transition-all {{ request()->routeIs('user.account.favorites*') ? 'bg-[#CD2828]/10 text-[#CD2828]' : 'text-gray-400' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" stroke-width="2.5"/></svg>
            </div>
            <span class="text-[9px] font-black uppercase tracking-tighter {{ request()->routeIs('user.account.favorites*') ? 'text-[#CD2828]' : 'text-gray-400' }}">Koleksi</span>
        </a>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}" class="flex flex-col items-center m-0"> {{-- Tambah flex & m-0 --}}
            @csrf
            <button type="submit" class="group flex flex-col items-center gap-1 transition-all duration-300">
                <div class="p-2 rounded-2xl text-gray-400 hover:bg-red-50 hover:text-[#CD2828] transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>
                <span class="text-[9px] font-black uppercase tracking-tighter text-gray-400">Keluar</span>
            </button>
        </form>

    </div>
</div>