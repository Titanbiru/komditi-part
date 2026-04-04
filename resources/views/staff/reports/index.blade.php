@extends('layouts.staff')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Staff Dashboard Report</h1>
</div>

{{-- AREA NAVIGASI (Tanpa Form agar tidak error) --}}
<div class="bg-white border-2 border-black rounded-3xl p-6 mb-10 shadow-sm">
    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
        <a href="{{ route('staff.reports.index') }}" class="bg-gray-200 p-2 rounded-full hover:bg-gray-300 transition-all shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
        </a>

        <div class="flex items-center gap-4">
            <span class="font-bold text-xs uppercase tracking-widest text-gray-500">Type:</span>
            <div class="flex gap-2">
                @php
                    $menus = [
                        ['name' => 'Sales', 'route' => 'staff.reports.sales'],
                        ['name' => 'Stock', 'route' => 'staff.reports.stocks'],
                        ['name' => 'Transaction', 'route' => 'staff.reports.transactions'],
                    ];
                @endphp
                @foreach($menus as $menu)
                <label class="cursor-pointer group">
                    <input type="radio" name="report_type" value="{{ route($menu['route']) }}" class="hidden peer nav-report" 
                        {{ Route::currentRouteName() == $menu['route'] ? 'checked' : '' }}>
                    <span class="px-6 py-1 rounded-full border-2 border-black text-sm font-bold transition-all 
                        peer-checked:bg-[#CD2828] peer-checked:text-white peer-checked:border-[#CD2828] group-hover:bg-gray-100">
                        {{ $menu['name'] }}
                    </span>
                </label>
                @endforeach
            </div>
        </div>

        <button type="button" onclick="pindahLaporan()" class="bg-[#1BCFD5] text-white px-6 py-2 rounded-full font-black uppercase tracking-tighter shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-y-1 hover:shadow-none transition-all">
            Show
        </button>
    </div>
</div>

{{-- STATS CARD --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-12 max-w-5xl mx-auto">
    <div class="border-2 border-[#CD2828] rounded-2xl p-8 bg-white text-center shadow-sm">
        <h3 class="text-lg font-bold mb-2">Revenue (Year: {{ $year }})</h3>
        <p class="text-3xl font-black text-[#CD2828]">Rp {{ number_format($monthlyRevenue->sum(), 0, ',', '.') }}</p>
    </div>
    <div class="border-2 border-[#CD2828] rounded-2xl p-8 bg-white text-center shadow-sm">
        <h3 class="text-lg font-bold mb-2">New Customers (Year: {{ $year }})</h3>
        <p class="text-4xl font-black text-[#CD2828]">{{ $monthlyCustomers->sum() }}</p>
    </div>
</div>

{{-- CHART --}}
<div class="bg-white p-6 rounded-2xl border-2 border-black shadow-sm relative">
    <div class="absolute right-6 top-6">
        <form method="GET" action="{{ route('staff.reports.index') }}">
            <select name="year" onchange="this.form.submit()" class="bg-[#CD2828] text-white px-4 py-1 rounded-lg font-bold text-sm outline-none cursor-pointer">
                <option value="2026" {{ $year == '2026' ? 'selected' : '' }}>2026</option>
                <option value="2025" {{ $year == '2025' ? 'selected' : '' }}>2025</option>
            </select>
        </form>
    </div>
    <canvas id="reportChart" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function pindahLaporan() {
        const selected = document.querySelector('input.nav-report:checked');
        if (selected) window.location.href = selected.value;
    }

    const ctx = document.getElementById('reportChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: 'Revenue',
                    data: @json(array_values($monthlyRevenue->toArray())),
                    borderColor: '#7C3AED',
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(124, 58, 237, 0.1)'
                },
                {
                    label: 'Customers',
                    data: @json(array_values($monthlyCustomers->toArray())),
                    borderColor: '#F87171',
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(248, 113, 113, 0.1)'
                }
            ]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });
</script>
@endsection