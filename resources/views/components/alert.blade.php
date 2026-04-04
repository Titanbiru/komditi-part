{{-- resources/views/components/alert.blade.php --}}

@if(session()->has('success'))
    <div id="alert-success" class="fixed top-5 right-5 z-[100] animate-bounce-in">
        <div class="bg-black text-white px-6 py-4 rounded-2xl shadow-2xl border-l-4 border-[#CD2828] flex items-center gap-4">
            <div class="bg-[#CD2828] p-1.5 rounded-lg">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest leading-none mb-1 text-gray-400">Berhasil</p>
                <p class="text-sm font-bold">{{ session('success') }}</p>
            </div>
            <button onclick="document.getElementById('alert-success').remove()" class="ml-4 text-gray-500 hover:text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2"></path></svg>
            </button>
        </div>
    </div>
@endif

@if(session()->has('error'))
    <div id="alert-error" class="fixed top-5 right-5 z-[100] animate-bounce-in">
        <div class="bg-white border border-red-100 px-6 py-4 rounded-2xl shadow-2xl border-l-4 border-red-600 flex items-center gap-4">
            <div class="bg-red-600 p-1.5 rounded-lg">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest leading-none mb-1 text-red-400">Gagal</p>
                <p class="text-sm font-bold text-gray-800">{{ session('error') }}</p>
            </div>
        </div>
    </div>
@endif

<script>
    // Biar notif hilang otomatis setelah 3 detik
    setTimeout(() => {
        const s = document.getElementById('alert-success');
        const e = document.getElementById('alert-error');
        if(s) s.style.display = 'none';
        if(e) e.style.display = 'none';
    }, 3000);
</script>