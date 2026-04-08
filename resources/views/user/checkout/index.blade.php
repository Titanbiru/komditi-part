@extends('layouts.public')

@section('content')
<div class="container mx-auto px-4">
    <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
            <div style="background: red; color: white; padding: 20px; border-radius: 15px; margin-bottom: 20px;">
                <p><strong>Waduh Mas, ada yang belum diisi:</strong></p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if($cart && $cart->items)
            @foreach($cart->items as $item)
                <input type="hidden" name="cart_ids[]" value="{{ $item->id }}">
            @endforeach
        @endif
        <input type="hidden" name="shipping_cost" id="shipping-cost-input" value="25000">
        <input type="hidden" name="unique_code" id="unique-code-input" value="0">
        <input type="hidden" name="grand_total" id="grand-total-input" value="0">
        <div class="flex flex-col lg:flex-row gap-8">
            
            {{-- SISI KIRI: DETAIL BILLING --}}
            <div class="w-full lg:w-2/3">
                <div class="bg-white border border-gray-200 rounded-[2rem] p-8 shadow-sm space-y-8">
                    <h2 class="text-[#CD2828] font-black italic uppercase text-sm tracking-widest border-b border-gray-100 pb-4">Detail Billing</h2>

                    {{-- Nama & Email --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-2">Nama Penerima</label>
                            <input required type="text" name="name" 
                                value="{{ old('name', Auth::user()->name) }}" 
                                class="w-full bg-white border border-gray-200 rounded-2xl px-6 py-3 text-sm font-bold focus:outline-none focus:border-[#CD2828] transition-all"
                                placeholder="Masukkan nama penerima">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-2">Email Konfirmasi</label>
                            <input required type="email" name="email" 
                                value="{{ old('email', Auth::user()->email) }}" 
                                class="w-full bg-white border border-gray-200 rounded-2xl px-6 py-3 text-sm font-bold focus:outline-none focus:border-[#CD2828] transition-all"
                                placeholder="email@contoh.com">
                        </div>
                    </div>

                    {{-- No Telp --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-500 uppercase ml-2">No Telp</label>
                        <input required type="text" name="phone" placeholder="0857xxxxxxxxx" class="w-full bg-white border border-gray-200 rounded-2xl px-6 py-3 text-sm focus:outline-none focus:border-[#CD2828]">
                    </div>

                    {{-- Alamat --}}
                    <select name="address" class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-6 py-3 text-sm focus:outline-none focus:border-[#CD2828] appearance-none" required>
                        @forelse(Auth::user()->addresses as $addr)
                            <option value="{{ $addr->id }}" {{ $addr->is_default ? 'selected' : '' }}>
                                [{{ $addr->recipient_name }}] - {{ Str::limit($addr->address, 50) }}...
                            </option>
                        @empty
                            <option value="">Belum ada alamat, silakan tambah dulu!</option>
                        @endforelse
                    </select>

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

                    {{-- Bagian Pembayaran & Bukti Transfer --}}
                    <div class="space-y-6 bg-gray-50 p-8 rounded-[2.5rem] border-2 border-dashed border-gray-200">
                        <div class="text-center space-y-6">
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Metode Pembayaran</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                                {{-- PILIHAN QRIS --}}
                                <label class="relative group cursor-pointer">
                                    <input type="radio" name="payment" value="qris" class="peer hidden" checked>
                                    <div class="bg-white p-6 rounded-3xl shadow-sm border-2 border-transparent peer-checked:border-[#CD2828] peer-checked:bg-red-50/50 transition-all duration-300">
                                        {{-- Ukuran dinaikkan dari w-40 ke w-64 --}}
                                        <div class="relative overflow-hidden rounded-xl mb-4 group-hover:scale-105 transition-transform duration-500">
                                            <img src="{{ Storage::url(get_setting('qris_image')) }}" 
                                                class="w-64 mx-auto block shadow-sm border-4 border-white"
                                                alt="QRIS Komditi Part">
                                        </div>
                                        <p class="text-[10px] font-black text-gray-400 peer-checked:text-[#CD2828] uppercase mt-2 italic">
                                            Scan & Bayar Pakai QRIS
                                        </p>
                                    </div>
                                    
                                    {{-- Centang Indikator --}}
                                    <div class="absolute -top-2 -right-2 bg-[#CD2828] text-white rounded-full p-1 opacity-0 peer-checked:opacity-100 transition-opacity z-10 shadow-lg">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                        </svg>
                                    </div>
                                </label>

                                {{-- PILIHAN BANK TRANSFER --}}
                                <label class="relative group cursor-pointer text-left">
                                    <input type="radio" name="payment" value="bank_transfer" class="peer hidden">
                                    <div class="bg-white p-5 rounded-3xl shadow-sm border-2 border-transparent peer-checked:border-[#CD2828] peer-checked:bg-red-50/50 transition-all duration-300 relative overflow-hidden">
                                        <div class="absolute top-0 right-0 bg-[#CD2828] text-white px-3 py-1 rounded-bl-xl text-[8px] font-black uppercase italic">
                                            {{ get_setting('bank_name') }}
                                        </div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Nomor Rekening:</p>
                                        <p class="text-xl font-black text-black italic tracking-tighter my-1">{{ get_setting('bank_account') }}</p>
                                        <p class="text-[10px] font-bold text-gray-500 uppercase italic leading-none">a.n {{ get_setting('bank_holder') }}</p>
                                        <p class="text-[9px] font-black text-[#CD2828] uppercase mt-3 opacity-0 peer-checked:opacity-100 italic">Transfer Bank Selected</p>
                                    </div>
                                    {{-- Centang Indikator --}}
                                    <div class="absolute -top-2 -right-2 bg-[#CD2828] text-white rounded-full p-1 opacity-0 peer-checked:opacity-100 transition-opacity">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                                    </div>
                                </label>
                            </div>

                            <hr class="border-gray-200 w-1/3 mx-auto">

                            {{-- Area Upload Bukti --}}
                            <div class="space-y-4">
                                <h4 class="text-[10px] font-black text-gray-800 uppercase tracking-[0.1em]">Upload Bukti Transfer Kamu:</h4>
                                
                                <div class="relative inline-block">
                                    <img id="preview-proof" src="" 
                                        class="w-48 h-48 mx-auto rounded-2xl border-4 border-white shadow-2xl object-cover hidden transition-all duration-500 scale-100 hover:scale-105">
                                </div>

                                <div class="flex flex-col items-center gap-3">
                                    <label class="cursor-pointer bg-black text-white hover:bg-[#CD2828] px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg flex items-center gap-2 active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M16 8l-4-4m0 0L8 8m4-4v12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        Pilih File Bukti
                                        <input type="file" name="proof" class="hidden" onchange="previewImage(this)" required>
                                    </label>
                                    <p class="text-[9px] font-bold text-gray-400 uppercase italic">*Format: JPG, PNG (Maks 2MB)</p>
                                </div>
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
                        <div class="text-[10px] font-bold text-gray-400 uppercase">
                            Harga: 
                            @if($item->product->discount > 0)
                                <span class="line-through text-gray-300">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                            @endif
                            <span class="text-[#CD2828]">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="text-[10px] font-bold text-gray-400 uppercase">Qty: {{ $item->quantity }}</div>
                        @if($item->product->discount > 0)
                            <div class="text-[10px] font-bold text-green-500 uppercase italic">Save {{ $item->product->discount }}% OFF</div>
                        @endif
                    </div>
                    @endforeach

                    @php
                        // 1. Ambil harga apa adanya dari keranjang (karena sudah harga diskon dari CartController)
                        $subtotalFinal = $cart->items->sum(function($item) {
                            return $item->price * $item->quantity;
                        });

                        // 2. Ambil biaya admin
                        $adminFee = (int) get_setting('admin_fee', 2500); 

                        // 3. Gabungkan Subtotal + Admin
                        $initialTotalWithAdmin = $subtotalFinal + $adminFee;
                    @endphp

                    <div class="space-y-3 pt-4 border-t border-gray-100">
                        <div class="flex justify-between text-xs">
                            <span class="font-bold text-gray-400 uppercase">Biaya admin:</span>
                            <span class="font-black text-gray-800">Rp {{ number_format($adminFee, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-xs">
                            <span class="font-bold text-gray-400 uppercase">Biaya ongkir:</span>
                            <span id="display-shipping" class="font-black text-gray-800">Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-xs font-black text-gray-800 uppercase italic">Total:</span>
                            {{-- Gunakan $initialTotalWithAdmin di data-subtotal --}}
                            <span id="display-total" 
                                class="text-lg font-black text-[#CD2828]" 
                                data-subtotal="{{ $initialTotalWithAdmin }}">
                                Rp {{ number_format($initialTotalWithAdmin, 0, ',', '.') }}
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
        const subtotal = parseInt(document.getElementById('display-total').dataset.subtotal);
        const uniqueCode = Math.floor(Math.random() * 899) + 100; 
        
        const total = subtotal + shippingCost + uniqueCode;
        
        document.getElementById('display-shipping').innerText = 'Rp ' + shippingCost.toLocaleString('id-ID');
        document.getElementById('display-total').innerText = 'Rp ' + total.toLocaleString('id-ID');
        
        // UPDATE BAGIAN INI SAMA DENGAN NAMA INPUT DI ATAS
        document.getElementById('shipping-cost-input').value = shippingCost;
        document.getElementById('unique-code-input').value = uniqueCode;
        document.getElementById('grand-total-input').value = total; 
    }

    // Fungsi Preview Gambar
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview-proof');
                preview.src = e.target.result;
                // Hapus class hidden supaya gambarnya muncul pas dipilih
                preview.classList.remove('hidden'); 
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Jalankan otomatis saat halaman pertama kali dibuka
    window.onload = () => updateTotal(25000); // Default J&T Reguler
</script>
@endsection