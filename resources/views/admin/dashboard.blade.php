@extends ('layouts.admin')

@section('content')
    

    <!-- Grid Card Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Card 1: Admin/Staff/User -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 text-center">
            <h3 class="text-lg font-semibold text-[#202020] mb-3">Admin/Staff/User (customer)</h3>
            <p class="text-2xl font-bold text-[#CD2828]">
                {{ $totalAdmins }}/{{ $totalStaff }}/{{ $totalCustomers }}
            </p>
        </div>

        <!-- Card 2: Sales Report this month -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 text-center">
            <h3 class="text-lg font-semibold text-[#202020] mb-3">Sales Report/month</h3>
            <p class="text-2xl font-bold text-[#CD2828]">Rp 12.330.000</p>
        </div>

        <!-- Card 3: Total Product -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 text-center">
            <h3 class="text-lg font-semibold text-[#202020] mb-3">Total product</h3>
            <p class="text-2xl font-bold text-[#CD2828]">{{ $totalProducts }}</p>
        </div>

        <!-- Card 4: Total Transaction this month -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 text-center">
            <h3 class="text-lg font-semibold text-[#202020] mb-3">Total Transaction/month</h3>
            <p class="text-2xl font-bold text-[#CD2828]">{{ $totalOrders }}</p>
        </div>
    </div>

    <!-- Status Backup & Shortcut -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-[#202020]">Latest Backup</h2>
    </div>
    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <p class="text-sm text-gray-600">status backup</p>
            <div>
                <p class="font-medium text-[#202020]">
                    26/1/2026 
                    <span class="inline-block px-3 py-1 bg-[#1BCFD5] text-white text-xs font-semibold rounded-full ml-2">
                        done
                    </span>
                </p>
            </div>
        </div>
    </div>
@endsection