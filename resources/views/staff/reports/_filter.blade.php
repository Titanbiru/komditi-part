<div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-6 mb-10 shadow-sm">
    <form id="reportForm" method="GET" class="flex flex-col lg:flex-row items-center justify-between gap-6">
        
        <div class="flex items-center gap-4">
            {{-- Tombol Back Minimalis --}}
            <a href="{{ route('staff.reports.index') }}" class="bg-[#F9F9F9] p-3 rounded-2xl hover:bg-[#202020] hover:text-white transition-all text-[#BABABA]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>

            {{-- Date Range (Ganti border hitam jadi abu-abu tipis) --}}
            <div class="flex items-center bg-[#F9F9F9] rounded-2xl px-5 py-2 border border-[#BABABA]/10 group focus-within:border-[#CD2828]/30 transition-all">
                <input type="date" name="start" value="{{ request('start') }}" 
                    class="bg-transparent py-1 text-[10px] font-black uppercase focus:outline-none text-[#202020]">
                <span class="font-black mx-3 text-[#BABABA] text-[9px]">TO</span>
                <input type="date" name="end" value="{{ request('end') }}" 
                    class="bg-transparent py-1 text-[10px] font-black uppercase focus:outline-none text-[#202020]">
            </div>
        </div>
        
        <div class="flex items-center gap-6">
            {{-- Report Type Selector --}}
            <div class="flex items-center gap-4">
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
            </div>

            {{-- Tombol Show (Ganti Shadow Hitam jadi Shadow Soft) --}}
            <button type="submit" class="bg-[#202020] text-[#FEFEFE] px-10 py-3 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-[#CD2828] transition-all shadow-lg active:scale-95">
                Generate
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('reportForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const selectedUrl = document.querySelector('input[name="report_type"]:checked').value;
        this.action = selectedUrl;
        this.submit();
    });
</script>