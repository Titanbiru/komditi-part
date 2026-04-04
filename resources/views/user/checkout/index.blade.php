@extends('layouts.public')

@section('content')
<div class="container mx-auto px-4">
    <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="flex flex-col lg:flex-row gap-8">
            
            {{-- SISI KIRI: DETAIL BILLING --}}
            <div class="w-full lg:w-2/3">
                <div class="bg-white border border-gray-200 rounded-[2rem] p-8 shadow-sm space-y-8">
                    <h2 class="text-[#CD2828] font-black italic uppercase text-sm tracking-widest border-b border-gray-100 pb-4">Detail Billing</h2>

                    {{-- Nama & Email --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-2">Nama</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-6 py-3 text-sm focus:outline-none focus:border-[#CD2828]" readonly>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-2">Email</label>
                            <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-6 py-3 text-sm focus:outline-none focus:border-[#CD2828]" readonly>
                        </div>
                    </div>

                    {{-- No Telp --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-500 uppercase ml-2">No Telp</label>
                        <input type="text" name="phone" placeholder="0857xxxxxxxxx" class="w-full bg-white border border-gray-200 rounded-2xl px-6 py-3 text-sm focus:outline-none focus:border-[#CD2828]">
                    </div>

                    {{-- Alamat --}}
                    <div class="space-y-2">
                        <div class="flex justify-between items-center ml-2">
                            <label class="text-xs font-bold text-gray-500 uppercase italic">Pilih alamat pengiriman</label>
                            <a href="{{ route('user.account.addresses.create') }}" class="text-cyan-400 text-[10px] font-black uppercase underline">Tambah Baru</a>
                        </div>
                        
                        <select name="address_id" class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-6 py-3 text-sm focus:outline-none focus:border-[#CD2828] appearance-none" required>
                            @forelse(Auth::user()->addresses as $addr)
                                <option value="{{ $addr->id }}" {{ $addr->is_default ? 'selected' : '' }}>
                                    [{{ $addr->recipient_name }}] - {{ Str::limit($addr->address, 50) }}...
                                </option>
                            @empty
                                <option value="">Belum ada alamat, silakan tambah dulu!</option>
                            @endforelse
                        </select>
                    </div>

                    {{-- Pilihan Pengiriman --}}

                    {{-- Pengiriman dengan Estimasi --}}
                    <div class="space-y-4">
                        <label class="text-xs font-bold text-gray-500 uppercase ml-2 italic">Pilih jenis pengiriman:</label>
                        <div class="grid grid-cols-1 gap-3">
                            
                            {{-- J&T Reguler --}}
                            <label class="relative flex items-center p-4 border border-gray-200 rounded-2xl cursor-pointer hover:border-[#CD2828] has-[:checked]:border-[#CD2828] has-[:checked]:bg-red-50/30 transition-all">
                                <input type="radio" name="shipping" value="25000" class="w-4 h-4 accent-[#CD2828]" onchange="updateTotal(25000)" checked>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b0/J%26T_Express_logo.svg" class="h-5 mx-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-gray-800 uppercase">J&T Reguler (2-3 Hari)</span>
                                    <span class="text-xs font-bold text-[#CD2828]">Rp 25.000</span>
                                </div>
                            </label>

                            {{-- J&T ECO (Ekonomi) --}}
                            <label class="relative flex items-center p-4 border border-gray-200 rounded-2xl cursor-pointer hover:border-[#CD2828] has-[:checked]:border-[#CD2828] has-[:checked]:bg-red-50/30 transition-all">
                                <input type="radio" name="shipping" value="18000" class="w-4 h-4 accent-[#CD2828]" onchange="updateTotal(18000)">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b0/J%26T_Express_logo.svg" class="h-5 mx-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-gray-800 uppercase">J&T ECO (5-7 Hari)</span>
                                    <span class="text-xs font-bold text-[#CD2828]">Rp 18.000</span>
                                </div>
                            </label>

                            {{-- J&T CARGO (Untuk barang berat) --}}
                            <label class="relative flex items-center p-4 border border-gray-200 rounded-2xl cursor-pointer hover:border-[#CD2828] has-[:checked]:border-[#CD2828] has-[:checked]:bg-red-50/30 transition-all">
                                <input type="radio" name="shipping" value="50000" class="w-4 h-4 accent-[#CD2828]" onchange="updateTotal(50000)">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b0/J%26T_Express_logo.svg" class="h-5 mx-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-gray-800 uppercase">J&T CARGO (Khusus Berat DIATAS 10Kg)</span>
                                    <span class="text-xs font-bold text-[#CD2828]">Rp 50.000</span>
                                </div>
                            </label>

                            {{-- J&T Super --}}
                            <label class="relative flex items-center p-4 border border-gray-200 rounded-2xl cursor-pointer hover:border-[#CD2828] has-[:checked]:border-[#CD2828] has-[:checked]:bg-red-50/30 transition-all">
                                <input type="radio" name="shipping" value="64000" class="w-4 h-4 accent-[#CD2828]" onchange="updateTotal(64000)">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b0/J%26T_Express_logo.svg" class="h-5 mx-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-gray-800 uppercase">J&T Super (Esok Sampai)</span>
                                    <span class="text-xs font-bold text-[#CD2828]">Rp 64.000</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Tambahkan Kolom Catatan --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-500 uppercase ml-2">Catatan untuk Kurir (Opsional)</label>
                        <textarea name="notes" rows="2" placeholder="Contoh: Pagar warna merah, titip di satpam..." class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-6 py-3 text-sm focus:outline-none focus:border-[#CD2828]"></textarea>
                    </div>

                    {{-- Metode Pembayaran --}}
                    <div class="space-y-4">
                        <label class="text-xs font-bold text-gray-500 uppercase ml-2 italic">Metode pembayaran:</label>
                        <div class="flex gap-4">
                            <label class="flex-1 flex items-center gap-3 p-4 border border-gray-200 rounded-2xl cursor-pointer has-[:checked]:border-[#CD2828]">
                                <input type="radio" name="payment" value="qris" class="accent-[#CD2828]" checked>
                                <span class="font-black italic text-lg uppercase">QRIS</span>
                            </label>
                            <label class="flex-1 flex items-center gap-3 p-4 border border-gray-200 rounded-2xl cursor-pointer has-[:checked]:border-[#CD2828]">
                                <input type="radio" name="payment" value="jago" class="accent-[#CD2828]">
                                <span class="font-black italic text-lg uppercase text-orange-500">Jago</span>
                            </label>
                        </div>
                    </div>

                    {{-- Bukti Transfer --}}
                    <div class="space-y-6 bg-gray-50 p-8 rounded-[2.5rem] border-2 border-dashed border-gray-200">
                        <div class="text-center space-y-4">
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Scan QRIS & Upload Bukti</h4>
                            
                            {{-- Area Preview Gambar --}}
                            <div class="relative inline-block group">
                                <img id="preview-proof" src="{{ asset('images/qris-sample.png') }}" 
                                    class="w-44 mx-auto rounded-2xl border-4 border-white shadow-xl transition-transform group-hover:scale-105 duration-500">
                            </div>
                            
                            <div class="flex flex-col items-center gap-3 pt-2">
                                <label class="cursor-pointer bg-black text-white hover:bg-[#CD2828] px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M16 8l-4-4m0 0L8 8m4-4v12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    Pilih Bukti Transfer
                                    <input type="file" name="proof" class="hidden" onchange="previewImage(this)" required>
                                </label>
                                <p class="text-[9px] font-bold text-gray-400 uppercase italic">*Format: JPG, PNG (Maks 2MB)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SISI KANAN: PESANAN KAMU (Sticky) --}}
            <div class="w-full lg:w-1/3">
                <div class="bg-white border border-gray-200 rounded-[2rem] p-8 shadow-sm sticky top-8 space-y-6">
                    <h2 class="text-[#CD2828] font-black italic uppercase text-sm tracking-widest">Pesanan kamu</h2>
                    
                    @foreach($cart->items as $item)
                    <div class="space-y-1">
                        <h3 class="text-[11px] font-black text-gray-800 uppercase leading-tight">{{ $item->product->name }}</h3>
                        <div class="text-[10px] font-bold text-gray-400 uppercase">Harga: Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                        <div class="text-[10px] font-bold text-gray-400 uppercase">Total barang: {{ $item->quantity }}</div>
                        <div class="text-[10px] font-bold text-red-500 uppercase">Diskon: -{{ $item->product->discount }}%</div>
                    </div>
                    @endforeach

                    @php
                        // Hitung subtotal yang sudah dipotong diskon tiap item
                        $subtotalFinal = $cart->items->sum(function($item) {
                            $hargaSetelahDiskon = $item->price - ($item->price * ($item->product->discount / 100));
                            return $hargaSetelahDiskon * $item->quantity;
                        });
                        $adminFee = 2500;
                        $initialTotal = $subtotalFinal + $adminFee;
                    @endphp
                    <div class="space-y-3 pt-4 border-t border-gray-100">
                        <div class="flex justify-between text-xs">
                            <span class="font-bold text-gray-400 uppercase">Biaya admin:</span>
                            <span class="font-black text-gray-800">Rp 2.500</span>
                        </div>
                        <div class="flex justify-between text-xs">
                            <span class="font-bold text-gray-400 uppercase">Biaya ongkir:</span>
                            <span id="display-shipping" class="font-black text-gray-800">Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                                <span class="text-xs font-black text-gray-800 uppercase italic">Total:</span>
                                {{-- UPDATE BAGIAN INI --}}
                                <span id="display-total" 
                                    class="text-lg font-black text-[#CD2828]" 
                                    data-subtotal="{{ $initialTotal }}">
                                    Rp {{ number_format($initialTotal, 0, ',', '.') }}
                                </span>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-[#CD2828] text-white py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-black transition-all shadow-lg shadow-red-100 active:scale-95">
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Fungsi untuk update total harga saat pilihan ongkir berubah
    function updateTotal(shippingCost) {
        // Ambil subtotal dari data-attribute yang kita buat tadi
        const subtotal = parseInt(document.getElementById('display-total').dataset.subtotal);
        
        // Kode unik 3 digit terakhir (Biar gampang verifikasi transfer)
        const uniqueCode = Math.floor(Math.random() * 899) + 100; 
        
        const total = subtotal + shippingCost + uniqueCode;
        
        // 1. Update Tampilan ke User
        document.getElementById('display-shipping').innerText = 'Rp ' + shippingCost.toLocaleString('id-ID');
        document.getElementById('display-total').innerText = 'Rp ' + total.toLocaleString('id-ID');
        
        // 2. Masukkan angka ke Input Hidden biar bisa dibaca Controller (Backend)
        document.getElementById('shipping-cost-input').value = shippingCost;
        document.getElementById('unique-code-input').value = uniqueCode;
        document.getElementById('total-amount-input').value = total;
    }

    // Fungsi Preview Gambar
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-proof').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Jalankan otomatis saat halaman pertama kali dibuka
    window.onload = () => updateTotal(25000); // Default J&T Reguler
</script>
@endsection