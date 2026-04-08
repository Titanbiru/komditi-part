<header class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            @php
                $isAdminOrStaff = auth()->check() && in_array(auth()->user()->role ?? '', ['admin', 'staff']);
            @endphp
            {{-- Logo --}}
            <div class="flex-shrink-0">
                @if (auth()->check())
                    @php
                        $user = auth()->user();
                        $dashboardUrl = match($user->role ?? 'user') {
                            'admin' => route('admin.dashboard'),
                            'staff' => route('staff.dashboard'),
                            default => route('public.index'), 
                        };
                    @endphp
                
                    
                    <div class="flex items-center flex-shrink-0">
                        {{-- TOMBOL HAMBURGER (Hanya muncul di Admin/Staff & Layar HP) --}}
                        @if($isAdminOrStaff)
                        <button onclick="toggleSidebar()" class="mr-4 lg:hidden text-[#202020] hover:text-[#CD2828] focus:outline-none">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7" />
                            </svg>
                        </button>
                        @endif
                        <a href="{{ $dashboardUrl }}" 
                        class="flex items-center text-[#202020] hover:text-[#CD2828] transition-colors">
                            <span class="text-2xl font-bold tracking-tighter">Komditi Part</span>
                        </a>
                    </div>
                @else
                    <a href="{{ url('/') }}" 
                    class="flex items-center text-[#202020] hover:text-[#CD2828] transition-colors">
                        <span class="text-2xl font-bold tracking-tighter">Komditi Part</span>
                    </a>
                @endif
            </div>

            
            {{-- Search Bar (hanya untuk guest + user) --}}
            @if (!$isAdminOrStaff)
            <div class="hidden md:flex flex-1 max-w-md mx-8">
                <form action="{{ route('search') }}" method="GET" class="w-full">
                    <div class="relative group">
                        <input 
                            type="text" 
                            name="q" 
                            placeholder="cari produk..." 
                            class="w-full bg-white border border-[var(--2nd-color)] rounded-full py-2.5 pl-11 pr-5 text-sm placeholder:text-[var(--2nd-color)] focus:outline-none focus:border-[var(--highlight)] focus:ring-2 focus:ring-[var(--highlight)] transition-all"
                        >
                        <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2 text-[var(--2nd-color)] group-hover:text-[var(--primary)] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 01-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
            @endif

            {{-- Right section: icons + profile --}}
            <div class="flex items-center gap-6">

                {{-- Favorite + Cart (hanya untuk guest + user) --}}
                @if (!$isAdminOrStaff)
                <a href="{{ route('user.account.favorites') }}" class="relative text-[#202020] hover:text-[#CD2828] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    @if (($favoritesCount ?? 0) > 0)
                        <span class="absolute -top-1 -right-1 bg-[#CD2828] text-[#FFFFFF] text-[10px] font-bold rounded-full h-5 w-5 flex items-center justify-center leading-none">{{ $favoritesCount }}</span>
                    @endif
                </a>

                <a href="{{ route('cart.index') }}" class="relative text-[#202020] hover:text-[#CD2828] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    @if (($cartCount ?? 0) > 0)
                        <span class="absolute -top-1 -right-1 bg-[#CD2828] text-[#FFFFFF] text-[10px] font-bold rounded-full h-5 w-5 flex items-center justify-center leading-none">{{ $cartCount }}</span>
                    @endif
                </a>
                @endif

                {{-- Profile / Login (selalu tampil, beda link sesuai role) --}}
                @auth
                    @php
                        $user = auth()->user();
                        $roleLabel = match($user->role) {
                            'admin' => '(Admin)',
                            'staff' => '(Staff)',
                            default => '(user)',
                        };
                        $profileLink = match($user->role) {
                            'admin' => route('admin.dashboard'),
                            'staff' => route('staff.dashboard'),
                            default => route('user.account.profile'),
                        };
                    @endphp

                    <a href="{{ $profileLink }}" 
                        class="flex items-center gap-2 text-[var(--text-color)] hover:text-[var(--primary)] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="hidden md:inline font-medium">{{ $user->name }}{{ $roleLabel }}</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                        class="flex items-center gap-2 text-[var(--text-color)] hover:text-[var(--primary)] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="hidden md:inline font-medium">Login</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>