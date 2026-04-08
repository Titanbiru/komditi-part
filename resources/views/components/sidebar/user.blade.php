<div class="w-full">
    <div class="bg-white border border-gray-100 rounded-[2.5rem] p-6 shadow-sm space-y-6 sticky top-24">
        <div class="px-2">
            <h2 class="text-sm font-bold text-gray-400">Hello, <span class="text-[#CD2828]">{{ Auth::user()->name }}!</span></h2>
        </div>

        <div class="flex flex-col gap-2">
            {{-- Menu Pengaturan --}}
            <a href="{{ route('user.account.profile') }}" 
               class="flex items-center gap-4 px-6 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest transition-all {{ request()->routeIs('user.account.profile') ? 'bg-[#CD2828] text-white shadow-lg shadow-red-100' : 'text-gray-500 hover:bg-gray-50 border border-transparent hover:border-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-width="2"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/></svg>
                Pengaturan
            </a>

            {{-- Menu Alamat --}}
            <a href="{{ route('user.account.addresses') }}" 
               class="flex items-center gap-4 px-6 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest transition-all {{ request()->routeIs('user.account.addresses*') ? 'bg-[#CD2828] text-white shadow-lg shadow-red-100' : 'text-gray-500 hover:bg-gray-50 border border-transparent hover:border-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/></svg>
                Alamat
            </a>

            {{-- Menu Pesanan --}}
            <a href="{{ route('user.account.orders') }}" 
               class="flex items-center gap-4 px-6 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest transition-all {{ request()->routeIs('user.account.orders*') ? 'bg-[#CD2828] text-white shadow-lg shadow-red-100' : 'text-gray-500 hover:bg-gray-50 border border-transparent hover:border-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                Riwayat Pesanan
            </a>

            {{-- Menu Produk / Favorit --}}
            <a href="{{ route('user.account.favorites') }}" 
                class="flex items-center gap-4 px-6 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest transition-all {{ request()->routeIs('user.account.favorites*') ? 'bg-[#CD2828] text-white shadow-lg shadow-red-100' : 'text-gray-500 hover:bg-gray-50 border border-transparent hover:border-gray-100' }}">
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