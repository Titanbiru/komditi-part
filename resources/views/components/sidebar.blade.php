<aside class="w-64 bg-[#CD2828] text-white h-screen fixed top-12 left-0 flex flex-col shadow-lg overflow-y-auto">
    <!-- Header Sidebar -->
    <div class="p-6 border-b border-[#832A2A] mt-4">
        <p class="text-sm opacity-80 mt-1">
            {{ ucfirst(auth()->user()->role) }} Panel
        </p>
    </div>

    <!-- Navigasi Menu -->
    <nav class="px-4 py-6 space-y-1.5">
        <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('staff.dashboard') }}" 
        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#832A2A] transition-colors 
                {{ (auth()->user()->role === 'admin' && request()->routeIs('admin.dashboard')) || 
                    (auth()->user()->role === 'staff' && request()->routeIs('staff.dashboard')) 
                    ? 'bg-[#832A2A]' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>

        <!-- Menu khusus Admin -->
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.users.index') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#832A2A] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512"><path fill="currentColor" fill-rule="evenodd" d="M362.667 234.667C409.813 234.667 448 272.853 448 320v128H64v-85.333c0-47.147 38.187-85.334 85.333-85.334h75.52c14.72-25.6 42.24-42.666 73.814-42.666Zm0 42.666h-64C275.2 277.333 256 296.533 256 320v85.333h149.333V320c0-23.467-19.2-42.667-42.666-42.667M213.333 320h-64c-23.466 0-42.666 19.2-42.666 42.667v42.666h106.666zm-42.666-192c35.285 0 64 28.715 64 64s-28.715 64-64 64c-35.286 0-64-28.715-64-64s28.714-64 64-64m0 40c-13.227 0-24 10.752-24 24s10.773 24 24 24s24-10.752 24-24s-10.774-24-24-24m160-104c41.173 0 74.666 33.493 74.666 74.667s-33.493 74.666-74.666 74.666c-41.174 0-74.667-33.493-74.667-74.666C256 97.493 289.493 64 330.667 64m0 42.667c-17.643 0-32 14.357-32 32c0 17.642 14.357 32 32 32c17.642 0 32-14.358 32-32c0-17.643-14.358-32-32-32"/></svg>
                User & Staff Management
            </a>
        @endif

        <!-- Menu yang sama untuk Admin & Staff -->
        <a href="{{ auth()->user()->role === 'admin' ? route('admin.products.index') : route('staff.products.index') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#832A2A] transition-colors {{ request()->routeIs('*.products.*') ? 'bg-[#832A2A]' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 2048 2048">
                <path fill="currentColor" d="m960 120l832 416v1040l-832 415l-832-415V536zm625 456L960 264L719 384l621 314zM960 888l238-118l-622-314l-241 120zM256 680v816l640 320v-816zm768 1136l640-320V680l-640 320z"/>
            </svg>
            Product
        </a>

        @if(auth()->user()->role === 'staff')
            <a href="{{ route('staff.stock.index') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#832A2A] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12 6V0H4v6H0v7h16V6zm-5 6H1V7h2v1h2V7h2zM5 6V1h2v1h2V1h2v5zm10 6H9V7h2v1h2V7h2zM0 16h3v-1h10v1h3v-2H0z"/></svg>
                Stock
            </a>
        

        <a href="{{ route('staff.transactions.index') }}" 
        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#832A2A] transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="2" d="M2 7h18m-4-5l5 5l-5 5m6 5H4m4-5l-5 5l5 5"/></svg>
            Transaction
        </a>
        @endif

        <a href="{{ auth()->user()->role === 'admin' ? route('admin.reports.index') : route('staff.reports.index') }}" 
        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#832A2A] transition-colors 
                {{ (auth()->user()->role === 'admin' && request()->routeIs('admin.reports.index')) || 
                    (auth()->user()->role === 'staff' && request()->routeIs('staff.reports.index')) 
                    ? 'bg-[#832A2A]' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M2.5 1.045a.5.5 0 0 0-.5.5v10.91a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V5.364a.5.5 0 0 0-.152-.36L7.911 1.188a.5.5 0 0 0-.348-.142zm7.766 3.819L8.063 2.727v2.137zM6 5.5H4v-1h2zM10 8H4V7h6zm-6 2.5h6v-1H4z" clip-rule="evenodd"/><path fill="currentColor" d="M13 7.5V14H4.5v1h9a.5.5 0 0 0 .5-.5v-7z"/></svg>
            Report
        </a>

        <!-- Menu khusus Admin -->
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.backup.index') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#832A2A] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M6.5 20q-2.275 0-3.887-1.575T1 14.575q0-1.95 1.175-3.475T5.25 9.15q.625-2.3 2.5-3.725T12 4q2.925 0 4.963 2.038T19 11q1.725.2 2.863 1.488T23 15.5q0 1.875-1.312 3.188T18.5 20H13q-.825 0-1.412-.587T11 18v-5.15L9.4 14.4L8 13l4-4l4 4l-1.4 1.4l-1.6-1.55V18h5.5q1.05 0 1.775-.725T21 15.5t-.725-1.775T18.5 13H17v-2q0-2.075-1.463-3.538T12 6T8.463 7.463T7 11h-.5q-1.45 0-2.475 1.025T3 14.5t1.025 2.475T6.5 18H9v2zm5.5-7"/></svg>
                Backup & Restore
            </a>
        @endif
    </nav>

    <!-- Logout (sama untuk semua) -->
    <div class="p-4 border-t border-[#832A2A]">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3 bg-[#832A2A] hover:bg-[#CD2828] rounded-lg transition-colors text-white font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                Log out
            </button>
        </form>
    </div>
</aside>