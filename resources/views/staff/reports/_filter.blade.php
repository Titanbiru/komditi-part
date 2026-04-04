<div class="bg-white border-2 border-black rounded-3xl p-6 mb-10 shadow-sm">
    <form id="reportForm" method="GET" class="flex flex-col md:flex-row items-center justify-between gap-6">
        
        <a href="{{ route('staff.reports.index') }}" class="bg-gray-200 p-2 rounded-full hover:bg-gray-300 transition-all shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
        </a>

        <div class="flex items-center gap-3">
            <span class="font-bold text-xs uppercase tracking-widest text-gray-500">Period:</span>
            <div class="flex items-center bg-gray-100 rounded-full px-2 border-2 border-black">
                <input type="date" name="start" value="{{ request('start') }}" class="bg-transparent px-3 py-1 text-sm font-bold focus:outline-none">
                <span class="font-bold">-</span>
                <input type="date" name="end" value="{{ request('end') }}" class="bg-transparent px-3 py-1 text-sm font-bold focus:outline-none">
            </div>
        </div>

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

        <button type="submit" class="bg-[#1BCFD5] text-white px-10 py-2 rounded-full font-black uppercase tracking-tighter shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-y-1 hover:shadow-none transition-all">
            Show 
        </button>
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