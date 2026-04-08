@extends('layouts.staff')

@section('content')
<div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 px-2">
    <div>
        <h1 class="text-3xl font-black text-[#202020] uppercase tracking-tighter">Dashboard Report</h1>
        <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Analytics & Data Overview</p>
    </div>
</div>

{{-- AREA NAVIGASI & FILTER --}}
<div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-6 mb-10 shadow-sm">
    <form id="reportForm" method="GET" class="flex flex-col lg:flex-row items-center justify-between gap-6">
        
        <div class="flex items-center gap-4">
            <a href="{{ route('staff.reports.index') }}" class="bg-[#F9F9F9] p-3 rounded-2xl hover:bg-[#202020] hover:text-white transition-all text-[#BABABA]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
            </a>
            
            {{-- Date Range Minimalis --}}
            <div class="flex items-center bg-[#F9F9F9] rounded-2xl px-4 py-2 border border-[#BABABA]/10">
                <input type="date" name="start" value="{{ request('start') }}" 
                    class="bg-transparent py-1 text-[10px] font-black uppercase focus:outline-none text-[#202020]">
                <span class="font-black mx-2 text-[#BABABA]">TO</span>
                <input type="date" name="end" value="{{ request('end') }}" 
                    class="bg-transparent py-1 text-[10px] font-black uppercase focus:outline-none text-[#202020]">
            </div>
        </div>

        <div class="flex items-center gap-6">
            <span class="font-black text-[9px] uppercase tracking-[0.2em] text-[#BABABA]">Select Type:</span>
            <div class="flex gap-2 bg-[#F9F9F9] p-1.5 rounded-2xl border border-[#BABABA]/5">
                @php    
                    $menus = [
                        ['name' => 'Sales', 'route' => 'staff.reports.sales'],
                        ['name' => 'Stock', 'route' => 'staff.reports.stocks'],
                        ['name' => 'Transaction', 'route' => 'staff.reports.transactions'],
                    ];
                @endphp
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

            <button type="submit" class="bg-[#202020] text-[#FEFEFE] px-10 py-3 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-[#CD2828] transition-all shadow-lg">
                Generate
            </button>
        </div>
    </form>
</div>

{{-- STATS CARD --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
    <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-10 text-center shadow-sm">
        <h3 class="text-[9px] font-black uppercase text-[#BABABA] mb-4 tracking-[0.3em]">Annual Revenue • {{ $year }}</h3>
        <p class="text-4xl font-black text-[#CD2828] tracking-tighter">Rp{{ number_format($monthlyRevenue->sum(), 0, ',', '.') }}</p>
    </div>
    <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-10 text-center shadow-sm">
        <h3 class="text-[9px] font-black uppercase text-[#BABABA] mb-4 tracking-[0.3em]">Acquired Customers • {{ $year }}</h3>
        <p class="text-4xl font-black text-[#202020] tracking-tighter">{{ number_format($monthlyCustomers->sum(), 0, ',', '.') }}</p>
    </div>
</div>

{{-- CHART AREA --}}
<div class="bg-white p-8 rounded-[2.5rem] border border-[#BABABA]/20 shadow-sm relative">
    <div class="flex justify-between items-center mb-8">
        <h4 class="text-[10px] font-black text-[#202020] uppercase tracking-[0.2em]">Monthly Growth Chart</h4>
        <select id="yearPicker" onchange="changeYear(this.value)" class="bg-[#F9F9F9] text-[#202020] px-4 py-2 rounded-xl font-black text-[10px] uppercase outline-none cursor-pointer border border-[#BABABA]/10">
            @foreach($availableYears as $y)
                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>YEAR: {{ $y }}</option>
            @endforeach
        </select>
    </div>
    <div class="w-full overflow-hidden">
        <canvas id="reportChart" height="120"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Handler Pindah Laporan
    document.getElementById('reportForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const selectedUrl = document.querySelector('input[name="report_type"]:checked').value;
        this.action = selectedUrl;
        this.submit();
    });

    // Handler Ganti Tahun
    function changeYear(val) {
        window.location.href = `?year=${val}`;
    }

    const ctx = document.getElementById('reportChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
            datasets: [
                {
                    label: 'REVENUE',
                    data: @json(array_values($monthlyRevenue->toArray())),
                    borderColor: '#CD2828', // Pakai primary Mas
                    borderWidth: 4,
                    pointBackgroundColor: '#CD2828',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 6,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(205, 40, 40, 0.05)'
                },
                {
                    label: 'CUSTOMERS',
                    data: @json(array_values($monthlyCustomers->toArray())),
                    borderColor: '#1BCFD5', // Pakai highlight Mas
                    borderWidth: 4,
                    pointBackgroundColor: '#1BCFD5',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 6,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(27, 207, 213, 0.05)'
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
                        font: { size: 10, weight: '900', family: 'DM Sans' }
                    }
                } 
            },
            scales: {
                y: { beginAtZero: true, grid: { display: false }, ticks: { font: { size: 9, weight: '700' } } },
                x: { grid: { display: false }, ticks: { font: { size: 9, weight: '700' } } }
            }
        }
    });
</script>
@endsection