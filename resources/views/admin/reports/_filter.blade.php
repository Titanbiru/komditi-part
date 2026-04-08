{{-- AREA NAVIGASI & DATE PICKER (RESPONSIVE) --}}
<div class="bg-white border border-[#BABABA]/20 rounded-[2rem] md:rounded-[2.5rem] p-4 md:p-6 mb-10 shadow-sm">
    <form id="reportForm" method="GET" class="flex flex-col gap-8">
        
        {{-- Row 1: Back Button & Type Selector (Scrollable di HP) --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                {{-- Tombol Back --}}
                <a href="{{ route('admin.reports.index') }}" class="bg-[#F9F9F9] p-3 rounded-2xl hover:bg-[#202020] hover:text-white transition-all text-[#BABABA]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>

                @php
                    $menus = [
                        ['name' => 'Sales', 'route' => 'admin.reports.sales'],
                        ['name' => 'Stock', 'route' => 'admin.reports.stocks'],
                        ['name' => 'Transaction', 'route' => 'admin.reports.transactions'],
                    ];
                @endphp

                {{-- Type Selector (Tab Style) - Scrollable di Mobile --}}
                <div class="flex gap-2 bg-[#F9F9F9] p-1.5 rounded-2xl border border-[#BABABA]/5 overflow-x-auto no-scrollbar">
                    @foreach($menus as $menu)
                    <label class="cursor-pointer group flex-shrink-0">
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

        {{-- Row 2: DATE RANGE PICKER & ACTIONS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end border-t border-[#F9F9F9] pt-8">
            
            {{-- Start Date --}}
            <div class="flex flex-col gap-2">
                <label class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest ml-1">Date From</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date', date('Y-m-01')) }}"
                    class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-3.5 text-[10px] font-black uppercase text-[#202020] focus:ring-1 focus:ring-[#CD2828] outline-none">
            </div>

            {{-- End Date --}}
            <div class="flex flex-col gap-2">
                <label class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest ml-1">Date To</label>
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date', date('Y-m-t')) }}"
                    class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-3.5 text-[10px] font-black uppercase text-[#202020] focus:ring-1 focus:ring-[#CD2828] outline-none">
            </div>

            {{-- Action Buttons --}}
            <div class="lg:col-span-2 flex gap-3">
                {{-- Submit Button --}}
                <button type="submit" class="flex-1 bg-[#202020] text-white py-4 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-[#CD2828] transition-all shadow-lg active:scale-[0.98]">
                    Generate Report
                </button>

                {{-- Download PDF Button (Hanya tampil jika bukan di index utama) --}}
                @if(Route::currentRouteName() !== 'admin.reports.index')
                <button type="button" onclick="downloadReport('{{ Route::currentRouteName() }}.pdf')" 
                    class="bg-white border border-[#BABABA]/20 text-[#CD2828] px-5 py-4 rounded-2xl hover:bg-[#CD2828] hover:text-white transition-all shadow-sm active:scale-95 group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </button>
                @endif
            </div>
        </div>
    </form>
</div>

<script>
    // Logic Pindah Page sesuai radio yang dipilih
    document.getElementById('reportForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const selectedRadio = document.querySelector('input[name="report_type"]:checked');
        if (selectedRadio) {
            this.action = selectedRadio.value;
            this.submit();
        }
    });

    // Logic Download PDF bawa data tanggal
    function downloadReport(pdfRouteName) {
        const start = document.getElementById('start_date').value;
        const end = document.getElementById('end_date').value;
        
        const routes = {
            'admin.reports.sales.pdf': "{{ route('admin.reports.sales.pdf') }}",
            'admin.reports.stocks.pdf': "{{ route('admin.reports.stocks.pdf') }}",
            'admin.reports.transactions.pdf': "{{ route('admin.reports.transactions.pdf') }}"
        };

        const baseUrl = routes[pdfRouteName];
        if (baseUrl) {
            window.location.href = `${baseUrl}?start=${start}&end=${end}`;
        }
    }
</script>

<style>
    /* Sembunyikan scrollbar tapi tetap bisa scroll di Mobile */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>