@extends('layouts.admin')

@section('content')
<div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 px-2">
    <div>
        <h1 class="text-3xl font-black text-[#202020] uppercase tracking-tighter">Executive Report</h1>
        <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Global Analytics & Business Growth</p>
    </div>
    {{-- Search Minimalis --}}
    <div class="relative w-full md:w-auto">
        <input type="text" placeholder="SEARCH ANALYTICS..." class="w-full md:w-80 bg-white border border-[#BABABA]/20 rounded-2xl px-6 py-3 text-[10px] font-black uppercase focus:outline-none focus:border-[#CD2828] shadow-sm">
    </div>
</div>

{{-- AREA NAVIGASI & DATE PICKER (RESPONSIVE) --}}
<div class="bg-white border border-[#BABABA]/20 rounded-[2rem] md:rounded-[2.5rem] p-4 md:p-6 mb-10 shadow-sm">
    <form id="reportForm" method="GET" class="flex flex-col gap-8">
        
        {{-- Row 1: Back Button & Type Selector (Scrollable di HP) --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.reports.index') }}" class="bg-[#F9F9F9] p-3 rounded-2xl hover:bg-[#202020] hover:text-white transition-all text-[#BABABA]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                </a>
                @php
                    $menus = [
                        ['name' => 'Sales', 'route' => 'admin.reports.sales'],
                        ['name' => 'Stock', 'route' => 'admin.reports.stocks'],
                        ['name' => 'Transaction', 'route' => 'admin.reports.transactions'],
                    ];
                @endphp
                <div class="flex gap-2 bg-[#F9F9F9] p-1.5 rounded-2xl border border-[#BABABA]/5">
                    @foreach($menus as $menu)
                    <label class="cursor-pointer group">
                    <input type="radio" name="report_type" value="{{ route($menu['route']) }}" class="hidden peer" 
                        {{ Route::currentRouteName() == $menu['route'] ? 'checked' : '' }}>
                    <span class="block px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all 
                        peer-checked:bg-white peer-checked:text-[#CD2828] peer-checked:shadow-sm text-[#BABABA] hover:text-[#202020]">
                        {{ $menu['name'] }}
                    </span>
                </label>
                    @endforeach
                </div>
            </div>
            
            {{-- Legend Singkat --}}
            <span class="hidden lg:block text-[9px] font-black text-[#BABABA] uppercase tracking-[0.3em]">Precision Analytics Mode</span>
        </div>

        {{-- Row 2: DATE RANGE PICKER & SUBMIT --}}
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 items-end border-t border-[#F9F9F9] pt-8">
            
            {{-- Start Date --}}
            <div class="flex flex-col gap-2">
                <label class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest ml-1">Date From</label>
                <input type="date" name="start_date" value="{{ request('start_date', date('Y-m-01')) }}"
                    class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-3.5 text-[10px] font-black uppercase text-[#202020] focus:ring-1 focus:ring-[#CD2828] outline-none">
            </div>

            {{-- End Date --}}
            <div class="flex flex-col gap-2">
                <label class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest ml-1">Date To</label>
                <input type="date" name="end_date" value="{{ request('end_date', date('Y-m-t')) }}"
                    class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-3.5 text-[10px] font-black uppercase text-[#202020] focus:ring-1 focus:ring-[#CD2828] outline-none">
            </div>

            {{-- Submit Button --}}
            <div class="lg:col-span-2">
                <button type="submit" class="w-full bg-[#CD2828] text-white py-4 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-[#202020] transition-all shadow-xl shadow-red-100 active:scale-[0.98]">
                    Generate Report
                </button>
            </div>
        </div>
    </form>
</div>

{{-- STATS CARD --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
    <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-10 text-center shadow-sm relative overflow-hidden group hover:border-[#CD2828] transition-all">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#CD2828]/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
        <h3 class="text-[9px] font-black uppercase text-[#BABABA] mb-4 tracking-[0.3em]">Monthly Revenue Overview</h3>
        <p class="text-4xl font-black text-[#CD2828] tracking-tighter">Rp{{ number_format($monthlyRevenue->sum(), 0, ',', '.') }}</p>
    </div>
    
    <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-10 text-center shadow-sm relative overflow-hidden group hover:border-[#1BCFD5] transition-all">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#1BCFD5]/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
        <h3 class="text-[9px] font-black uppercase text-[#BABABA] mb-4 tracking-[0.3em]">Customer Acquisition • Month</h3>
        <p class="text-5xl font-black text-[#202020] tracking-tighter">{{ number_format($monthlyCustomers->sum()) }}</p>
    </div>
</div>

{{-- CHART AREA --}}
<div class="bg-white p-8 rounded-[2.5rem] border border-[#BABABA]/20 shadow-sm relative">
    <div class="flex justify-between items-center mb-10">
        <h4 class="text-[10px] font-black text-[#202020] uppercase tracking-[0.2em]">Annual Growth Projection</h4>
        <select id="yearPicker" onchange="window.location.href='?year='+this.value" class="bg-[#F9F9F9] text-[#202020] px-4 py-2 rounded-xl font-black text-[10px] uppercase outline-none cursor-pointer border border-[#BABABA]/10">
            @foreach($availableYears as $y)
                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>Year: {{ $y }}</option>
            @endforeach
        </select>
    </div>
    <div class="w-full">
        <canvas id="reportChart" height="110"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('reportChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
            datasets: [
                {
                    label: 'REVENUE',
                    data: @json(array_values($monthlyRevenue->toArray())),
                    borderColor: '#CD2828',
                    borderWidth: 4,
                    pointBackgroundColor: '#CD2828',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 6,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(205, 40, 40, 0.03)'
                },
                {
                    label: 'CUSTOMERS',
                    data: @json(array_values($monthlyCustomers->toArray())),
                    borderColor: '#1BCFD5',
                    borderWidth: 4,
                    pointBackgroundColor: '#1BCFD5',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 6,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(27, 207, 213, 0.03)'
                }
            ]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: true,
            plugins: { 
                legend: { 
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 30,
                        font: { size: 10, weight: '900' }
                    }
                } 
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { display: false },
                    ticks: { font: { size: 9, weight: '700' } }
                },
                x: { 
                    grid: { display: false },
                    ticks: { font: { size: 9, weight: '700' } }
                }
            }
        }
    });

    // Handle form submission
    document.getElementById('reportForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const selectedUrl = document.querySelector('input[name="report_type"]:checked').value;
        this.action = selectedUrl;
        this.submit();
    });
</script>
@endsection