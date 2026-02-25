<header style="display: flex; background-color: white; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06); position: sticky; top: 0; z-index: 50;">
    <div style="max-width: 80rem; margin-left: auto; margin-right: auto; padding-left: 1rem; padding-right: 1rem; width: 100%;">
        <!-- Untuk mobile padding lebih kecil, desktop lebih besar -->
        <div style="display: flex; align-items: center; justify-content: space-between; height: 4rem;">

            <!-- Logo -->
            <div style="flex-shrink: 0;">
                <a href="{{ url('/') }}" style="display: flex; align-items: center; text-decoration: none;">
                    <!-- Ganti dengan logo SVG atau image kamu -->
                    <span style="margin-left: 0.75rem; font-size: 1.5rem; font-weight: 700; color: #111827;">Komditi Part</span>
                </a>
            </div>

            <!-- Search Bar (tengah) - sembunyi di mobile -->
            <div style="display: none; flex: 1; max-width: 36rem; margin-left: 2rem; margin-right: 2rem;" class="search-desktop">
                <form action="{{ route('search') }}" method="GET">
                    <div style="position: relative;">
                        <input 
                            type="text" 
                            name="q" 
                            placeholder="Cari produk, kategori..." 
                            style="width: 100%; padding-left: 2.5rem; padding-right: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem; border: 1px solid #d1d5db; border-radius: 9999px; outline: none; transition: all 0.2s;"
                            onfocus="this.style.boxShadow = '0 0 0 2px rgba(99,102,241,0.5)'; this.style.borderColor = '#6366f1';"
                            onblur="this.style.boxShadow = 'none'; this.style.borderColor = '#d1d5db';"
                        >
                        <button type="submit" style="position: absolute; top: 0; bottom: 0; left: 0; padding-left: 0.75rem; display: flex; align-items: center; border: none; background: none; cursor: pointer;">
                            <svg style="height: 1.25rem; width: 1.25rem; color: #9ca3af;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right section: icons + auth -->
            <div style="display: flex; align-items: center; gap: 1rem;">

                <!-- Favorite -->
                <a href="{{ route('favorites.index') }}" style="position: relative; color: #374151; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#dc2626'" onmouseout="this.style.color='#374151'">
                    <svg style="height: 1.5rem; width: 1.5rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    @if ($favoritesCount ?? 0 > 0)
                        <span style="position: absolute; top: -0.25rem; right: -0.25rem; background-color: #dc2626; color: white; font-size: 0.75rem; font-weight: bold; border-radius: 9999px; height: 1.25rem; width: 1.25rem; display: flex; align-items: center; justify-content: center;">
                            {{ $favoritesCount }}
                        </span>
                    @endif
                </a>

                <!-- Cart -->
                <a href="{{ route('cart.index') }}" style="position: relative; color: #374151; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#4f46e5'" onmouseout="this.style.color='#374151'">
                    <svg style="height: 1.75rem; width: 1.75rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    @if ($cartCount ?? 0 > 0)
                        <span style="position: absolute; top: -0.25rem; right: -0.25rem; background-color: #dc2626; color: white; font-size: 0.75rem; font-weight: bold; border-radius: 9999px; height: 1.25rem; width: 1.25rem; display: flex; align-items: center; justify-content: center;">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <!-- User / Login -->
                @auth
                    <div style="position: relative;" class="user-dropdown">
                        <button style="display: flex; align-items: center; gap: 0.5rem; background: none; border: none; cursor: pointer; padding: 0;">
                            <svg style="height: 1.75rem; width: 1.75rem; color: #374151; transition: color 0.2s;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span style="display: none; color: #1f2937; font-weight: 500;" class="user-name md:inline">
                                {{ Auth::user()->name }}
                                @if(Auth::user()->role === 'admin')
                                    <span style="font-size: 0.75rem; color: #9333ea;">(Admin)</span>
                                @elseif(Auth::user()->role === 'staff')
                                    <span style="font-size: 0.75rem; color: #16a34a;">(Staff)</span>
                                @endif
                            </span>
                        </button>

                        <!-- Dropdown -->
                        <div class="dropdown-menu" style="display: none; position: absolute; right: 0; margin-top: 0.5rem; width: 14rem; background-color: white; border-radius: 0.375rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding-top: 0.25rem; padding-bottom: 0.25rem; z-index: 50;">
                            
                            @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" style="display: block; padding: 0.5rem 1rem; font-size: 0.875rem; color: #7c3aed; text-decoration: none;">Dashboard Admin</a>
                            <a href="{{ route('admin.users') }}" style="display: block; padding: 0.5rem 1rem; font-size: 0.875rem; color: #7c3aed; text-decoration: none;">Kelola User</a>
                            <a href="{{ route('admin.products') }}" style="display: block; padding: 0.5rem 1rem; font-size: 0.875rem; color: #7c3aed; text-decoration: none;">Semua Produk</a>
                            @endif
                            
                            @if(Auth::user()->role === 'staff')
                                <a href="{{ route('staff.dashboard') }}" style="display: block; padding: 0.5rem 1rem; font-size: 0.875rem; color: #16a34a; text-decoration: none;">Dashboard Staff</a>
                                <a href="{{ route('staff.products') }}" style="display: block; padding: 0.5rem 1rem; font-size: 0.875rem; color: #16a34a; text-decoration: none;">Produk Saya</a>
                                <a href="{{ route('staff.orders') }}" style="display: block; padding: 0.5rem 1rem; font-size: 0.875rem; color: #16a34a; text-decoration: none;">Pesanan Masuk</a>
                            @endif

                            @if(!Auth::user()->role || Auth::user()->role === 'user')
                                <a href="{{ route('profile.index') }}" style="display: block; padding: 0.5rem 1rem; font-size: 0.875rem; color: #374151; text-decoration: none;">Profile</a>
                                <a href="{{ route('orders.index') }}" style="display: block; padding: 0.5rem 1rem; font-size: 0.875rem; color: #4f46e5; text-decoration: none;">Pesanan Saya</a>
                                <a href="{{ route('favorites.index') }}" style="display: block; padding: 0.5rem 1rem; font-size: 0.875rem; color: #4f46e5; text-decoration: none;">Favorit</a>
                            @endif

                            <hr style="margin: 0.25rem 0; border-color: #f3f4f6;" />

                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" style="display: block; width: 100%; text-align: left; padding: 0.5rem 1rem; font-size: 0.875rem; color: #b91c1c; background: none; border: none; cursor: pointer;">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" style="display: flex; align-items: center; gap: 0.5rem; color: #374151; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#4f46e5'" onmouseout="this.style.color='#374151'">
                        <svg style="height: 1.75rem; width: 1.75rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span style="display: none; font-weight: 500;" class="md:inline">Login</span>
                    </a>
                @endauth

                <!-- Mobile menu button -->
                <button style="display: none; color: #374151; background: none; border: none; cursor: pointer;" class="mobile-menu-btn md:hidden">
                    <svg style="height: 2rem; width: 2rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>