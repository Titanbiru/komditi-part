@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Report</h1>
    <div class="relative">
        <input type="text" placeholder="search" class="border border-[#BABABA] rounded-full px-4 py-2 text-sm focus:outline-none w-80 shadow-sm">
    </div>
</div>

<div class="bg-white border-2 border-black rounded-3xl p-6 mb-10 shadow-sm">
    <form id="reportForm" method="GET" class="flex flex-col md:flex-row items-center justify-between gap-6">
        
        <a href="{{ route('admin.reports.index') }}" class="bg-gray-200 p-2 rounded-full hover:bg-gray-300 transition-all shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
        </a>

        <div class="flex items-center gap-4">
            <span class="font-bold text-xs uppercase tracking-widest text-gray-500">Type:</span>
            <div class="flex gap-2">
                @php
                    $menus = [
                        ['name' => 'Sales', 'route' => 'admin.reports.sales'],
                        ['name' => 'Stock', 'route' => 'admin.reports.stocks'],
                        ['name' => 'Transaction', 'route' => 'admin.reports.transactions'],
                    ];
                @endphp
                @foreach($menus as $menu)
                <label class="cursor-pointer group">
                    <input type="radio" name="report_type" value="{{ route($menu['route']) }}" class="hidden peer" 
                        {{ Route::currentRouteName() == $menu['route'] ? 'checked' : '' }}>
                    <span class="px-6 py-1 rounded-full border-2 border-black text-sm font-bold transition-all 
                        peer-checked:bg-[#CD2828] peer-checked:text-white peer-checked:border-[#CD2828] group-hover:bg-gray-100">
                        {{ $menu['name'] }}
                    </span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-[#1BCFD5] text-white px-6 py-2 rounded-full font-black uppercase tracking-tighter shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-y-1 hover:shadow-none transition-all">
                Show
            </button>
        </div>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-12 max-w-5xl mx-auto">
    <div class="border-2 border-[#CD2828] rounded-2xl p-8 bg-white text-center relative">
        <h3 class="text-lg font-bold mb-2">Revenue *month</h3>
        <p class="text-3xl font-black text-[#CD2828]">Rp {{ number_format($monthlyRevenue->sum(), 0, ',', '.') }}</p>
    </div>
    <div class="border-2 border-[#CD2828] rounded-2xl p-8 bg-white text-center">
        <h3 class="text-lg font-bold mb-2">User(Customer) *month</h3>
        <p class="text-4xl font-black text-[#CD2828]">{{ $monthlyCustomers->sum() }}</p>
    </div>
</div>

<div class="bg-white p-6 rounded-2xl gap-6 border border-gray-200 shadow-sm relative">
    <div class="absolute right-6 top-6">
        <select id="yearPicker" class="bg-[#CD2828] text-white px-4 py-1 rounded-lg font-bold text-sm outline-none">
            <option value="2026">2026</option>
            <option value="2025">2025</option>
        </select>
    </div>
    <canvas id="reportChart" height="100"></canvas>
</div>

<script>
    const ctx = document.getElementById('reportChart').getContext('2d');
    const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'Desember'];
    
    // Data dari Controller
    const revenueData = @json(array_values($monthlyRevenue->toArray()));
    const customerData = @json(array_values($monthlyCustomers->toArray()));

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Revenue',
                    data: revenueData,
                    borderColor: '#7C3AED',
                    backgroundColor: 'rgba(124, 58, 237, 0.1)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Customers Register',
                    data: customerData,
                    borderColor: '#F87171',
                    backgroundColor: 'rgba(248, 113, 113, 0.1)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Script agar form pindah ke URL sesuai radio yang dipilih
    document.getElementById('reportForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Ambil URL dari value radio yang di-check
        const selectedUrl = document.querySelector('input[name="report_type"]:checked').value;
        
        // Update action form dan submit
        this.action = selectedUrl;
        this.submit();
    });

    // Logic Pindah Page
    document.getElementById('reportForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const selectedUrl = document.querySelector('input[name="report_type"]:checked').value;
        this.action = selectedUrl;
        this.submit();
    });
</script>
@endsection