@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4">
    <div class="bg-white border-2 border-gray-100 rounded-[2.5rem] p-8 md:p-10 shadow-sm max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-10 border-b border-gray-50 pb-6">
            <h1 class="text-xl font-black text-gray-800 uppercase tracking-tighter">Riwayat Pesanan</h1>
            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest bg-gray-50 px-4 py-2 rounded-full">
                Total: {{ $orders->total() }} Transaksi
            </span>
        </div>

        <div class="space-y-6">
            @forelse($orders as $order)
                <div class="border-2 border-gray-100 rounded-[2rem] p-6 hover:shadow-xl hover:border-gray-200 transition-all duration-300 bg-white group flex flex-col md:flex-row gap-6">
                    
                    {{-- 1. BAGIAN GAMBAR (Sudah Diperbaiki Sesuai Relasi Tabel Mas) --}}
                    <div class="w-full md:w-32 h-32 bg-gray-50 border border-gray-100 rounded-[1.5rem] flex-shrink-0 overflow-hidden relative group-hover:scale-[1.02] transition-transform">
                        @php
                            $firstItem = $order->items->first();
                            // INI YANG DIGANTI: Panggil images->first()->image_path
                            $gambarProduk = $firstItem?->product?->images->first()?->image_path; 
                        @endphp

                        @if($gambarProduk)
                            <img src="{{ Storage::url($gambarProduk) }}" class="w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-300">
                                <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-[8px] font-black uppercase tracking-widest">No Image</span>
                            </div>
                        @endif
                    </div>

                    {{-- 2. BAGIAN INFO TRANSAKSI --}}
                    <div class="flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="text-sm font-black text-gray-800 uppercase leading-tight line-clamp-2">
                                    {{ $firstItem?->product_name_snapshot ?? 'Produk Dihapus' }} 
                                    @if($order->items->count() > 1) 
                                        <span class="text-gray-400 font-bold ml-1 text-xs lowercase">dan {{ $order->items->count() - 1 }} produk lainnya...</span>
                                    @endif
                                </h4>
                            </div>
                            
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">
                                ORDER ID: <span class="text-gray-800">{{ $order->order_number }}</span> &bull; {{ $order->created_at->format('d M Y') }}
                            </p>
                        </div>

                        <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-xs font-bold uppercase">
                            <p class="text-gray-400 tracking-wider">Total Belanja: <span class="text-[#CD2828] font-black not text-sm">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span></p>
                            <p class="text-gray-400 tracking-wider">Jumlah: <span class="text-gray-800 font-black not">{{ $order->items->sum('quantity') }} Item</span></p>
                        </div>
                    </div>

                    {{-- 3. BAGIAN STATUS & AKSI --}}
                    <div class="flex flex-col justify-between items-start md:items-end md:border-l-2 md:border-dashed md:border-gray-100 md:pl-6 space-y-4 md:space-y-0 w-full md:w-48 gap-4">
                        
                        {{-- Badge Status --}}
                        <div class="w-full text-left md:text-right">
                            <p class="text-[8px] font-black uppercase tracking-widest text-gray-400 mb-1">Status Pesanan</p>
                            <span class="inline-block text-[10px] px-3 py-1.5 rounded-xl font-black uppercase tracking-widest
                                {{ $order->shipment_status == 'pending' ? 'bg-orange-50 text-orange-600 border border-orange-100' : '' }}
                                {{ $order->shipment_status == 'processing' ? 'bg-blue-50 text-blue-600 border border-blue-100' : '' }}
                                {{ $order->shipment_status == 'shipped' ? 'bg-indigo-50 text-indigo-600 border border-indigo-100' : '' }}
                                {{ $order->shipment_status == 'delivered' ? 'bg-green-50 text-green-600 border border-green-100' : '' }}
                                {{ $order->shipment_status == 'canceled' ? 'bg-red-50 text-red-600 border border-red-100' : '' }}">
                                {{ $order->shipment_status }}
                            </span>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex flex-col gap-2 w-full mt-auto">
                            {{-- TOMBOL CANCEL: Muncul selama status pengiriman masih PENDING --}}
                            @if($order->shipment_status == 'pending')
                                <form action="{{ route('user.account.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Yakin mau batalin pesanan ini, Mas?');">
                                    @csrf @method('PUT')
                                    <button type="submit" class="w-full bg-white text-red-600 border-2 border-red-100 hover:border-red-600 px-4 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all active:scale-95">
                                        Batalkan Pesanan
                                    </button>
                                </form>
                            @endif

                            {{-- TOMBOL DETAIL: Selalu Muncul --}}
                            <a href="{{ route('user.account.orders.show', $order->id) }}" class="text-center bg-gray-50 text-gray-800 hover:bg-black hover:text-white px-4 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all">
                                Lihat Detail
                            </a>
                            
                            {{-- TOMBOL TERIMA: Muncul jika sudah dikirim --}}
                            @if($order->shipment_status == 'shipped')
                                <button type="button" onclick="openReceiptModal('{{ $order->id }}', '{{ $order->order_number }}')" class="w-full bg-[#1BCFD5] text-white px-4 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:shadow-lg hover:shadow-cyan-200 transition-all active:scale-95">
                                    Pesanan Diterima
                                </button>
                            @endif
                        </div>
                    </div>

                </div>
            @empty
                <div class="text-center py-20 bg-gray-50 rounded-[2rem] border-2 border-dashed border-gray-100">
                    <p class="text-gray-400 font-bold uppercase text-xs tracking-widest">Belum ada riwayat belanja...</p>
                    <a href="{{ route('public.products') }}" class="inline-block mt-6 bg-black text-white px-8 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-[#CD2828] transition-all shadow-lg shadow-gray-200">
                        Mulai Belanja Sekarang
                    </a>
                </div>
            @endforelse
        </div>
        
        <div class="mt-10">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
{{-- Modal Receipt --}}
<div id="receiptModal" class="fixed inset-0 z-[999] hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-[2.5rem] w-full max-w-md p-8 shadow-2xl border-4 border-black relative">
            <button onclick="closeReceiptModal()" class="absolute top-6 right-6 text-gray-400 hover:text-black">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="3" stroke-linecap="round"/></svg>
            </button>

            <h3 class="text-lg font-black uppercase text-gray-800 mb-2">Konfirmasi Terima</h3>
            <p id="modalOrderNumber" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6"></p>

            <form id="receiptForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                
                <div class="space-y-4 mb-8">
                    <label class="block text-[10px] font-black uppercase text-gray-500 ml-2">Foto Barang Diterima (Harus Diisi)</label>
                    <div class="relative group">
                        <div id="previewContainer" class="hidden mb-4 rounded-2xl overflow-hidden border-2 border-black aspect-video">
                            <img id="imagePreview" src="" class="w-full h-full object-cover">
                        </div>
                        <label class="flex flex-col items-center justify-center w-full h-32 border-4 border-dashed border-gray-100 rounded-3xl cursor-pointer hover:border-[#1BCFD5] hover:bg-cyan-50 transition-all group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-2 text-gray-400 group-hover:text-[#1BCFD5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M16 8l-4-4m0 0L8 8m4-4v12" stroke-width="2.5" stroke-linecap="round"/></svg>
                                <p class="text-[10px] font-black text-gray-400 group-hover:text-[#1BCFD5] uppercase tracking-widest">Klik untuk Upload Foto</p>
                            </div>
                            <input require type="file" name="receipt_image" class="hidden" onchange="previewReceipt(this)" accept="image/*" />
                        </label>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#1BCFD5] text-white py-4 rounded-2xl font-black uppercase tracking-widest shadow-[0_6px_0_0_#0ea5e9] active:translate-y-1 active:shadow-none transition-all">
                    Konfirmasi & Selesai
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openReceiptModal(orderId, orderNum) {
        const modal = document.getElementById('receiptModal');
        const form = document.getElementById('receiptForm');
        const text = document.getElementById('modalOrderNumber');
        
        // Update URL action form secara dinamis
        let url = "{{ route('user.account.orders.delivered', ':id') }}";
        form.action = url.replace(':id', orderId); 
        
        text.innerText = `ORDER ID: ${orderNum}`;
        modal.classList.remove('hidden');
    }

    function closeReceiptModal() {
        document.getElementById('receiptModal').classList.add('hidden');
    }

    function previewReceipt(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('previewContainer').classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>