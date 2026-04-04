@extends('layouts.admin')

@section('content')
<form action="{{ route('admin.products.update', $product) }}" id="productForm" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-[#CD2828]">Edit Product</h1>
        <div class="flex gap-3">
            <a href="{{ route('admin.products.index') }}" class="px-6 py-2 border border-[#BABABA] rounded-lg font-medium hover:bg-gray-50 transition-colors text-sm">
                Back
            </a>
            <button type="submit" onclick="submitProductForm()" class="px-6 py-2 bg-[#CD2828] text-white rounded-lg font-medium hover:bg-[#832A2A] transition-colors shadow-lg text-sm">
                Update Product
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
        <div class="md:col-span-2 space-y-6">
            <div>
                <label class="block text-sm font-medium mb-2 text-gray-700">Product Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border border-[#BABABA] rounded-xl px-4 py-3 focus:border-[#CD2828] outline-none transition-all" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2 text-gray-700">SKU Product</label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full border border-[#BABABA] rounded-xl px-4 py-3 focus:border-[#CD2828] outline-none transition-all" required>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-700">Price</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full border border-[#BABABA] rounded-xl px-4 py-3 focus:border-[#CD2828] outline-none transition-all" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-700">Discount (%)</label>
                    <input type="number" name="discount" value="{{ old('discount', $product->discount ?? 0) }}" class="w-full border border-[#BABABA] rounded-xl px-4 py-3 focus:border-[#CD2828] outline-none transition-all">
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-700">Stock</label>
                    <input type="number" name="stock" value="{{ $product->stock }}" readonly class="w-full border border-[#BABABA] rounded-xl px-4 py-3 focus:border-[#CD2828] outline-none transition-all cursor-not=allowed">
                </div>
            </div>

            <div class="bg-gray-50 p-5 rounded-2xl border border-[#BABABA] shadow-sm">
                <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wide">Category Selection</label>
                <div id="category_container" class="grid gap-3 bg-white p-4 border border-[#E5E5E5] rounded-xl overflow-y-auto custom-scrollbar shadow-inner">
                    @foreach($categories as $cat)
                        <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-red-50 cursor-pointer group transition-all">
                            <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}" 
                                {{ $product->categories->contains($cat->id) ? 'checked' : '' }}
                                class="accent-[#CD2828] w-4 h-4">
                            <span class="text-xs font-medium text-gray-700 group-hover:text-[#CD2828]">{{ $cat->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2 text-gray-700">Description</label>
                <textarea name="description" rows="8" class="w-full border border-[#BABABA] rounded-xl px-4 py-3 focus:border-[#CD2828] outline-none transition-all whitespace-pre-line">{{ old('description', $product->description) }}</textarea>
            </div>
        </div>

        <div class="space-y-6">
            <div class="space-y-6">
                <div class="bg-white p-5 rounded-2xl border border-[#BABABA] shadow-sm">
                    <div class="flex justify-between items-center mb-3">
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Add More Photos</label>
                            <p class="text-[10px] text-gray-400 italic">*Preview before update</p>
                        </div>
                        <label for="multi_image_input" class="cursor-pointer bg-white border border-[#CD2828] text-[#CD2828] p-2 rounded-lg hover:bg-red-50 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <input type="file" name="images[]" id="multi_image_input" class="hidden" accept="image/*" multiple onchange="handleMultipleFiles(this)">
                        </label>
                    </div>

                    <div id="gallery_preview_container" class="grid grid-cols-3 gap-2 min-h-[50px]">
                        </div>
                </div>

                @if($product->images->count() > 0)
                <div class="bg-white p-5 rounded-2xl border border-[#BABABA] shadow-sm">
                    <label class="block text-sm font-bold text-gray-700 mb-3">Existing Gallery</label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach($product->images as $img)
                            <div class="relative group aspect-square rounded-lg border border-gray-200 overflow-hidden shadow-sm" id="old-image-{{ $img->id }}">
                                <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover cursor-pointer" onclick="openZoomModal(this.src)">
                                <button type="button" onclick="deleteExistingImage({{ $img->id }})" class="absolute top-1 right-1 bg-white p-1 rounded-full text-red-600 hover:bg-red-600 hover:text-white shadow-md transition-all">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            @if($product->images->count() > 0)
            <div class="bg-white p-5 rounded-2xl border border-[#BABABA] shadow-sm">
                <label class="block text-sm font-bold text-gray-700 mb-3">Current Gallery</label>
                <div class="grid grid-cols-3 gap-2">
                    @foreach($product->images as $img)
                        <div class="relative group aspect-square rounded-lg border border-gray-200 overflow-hidden shadow-sm" id="old-image-{{ $img->id }}">
                            <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover">
                            <button type="button" onclick="deleteExistingImage({{ $img->id }})" class="absolute top-1 right-1 bg-white p-1 rounded-full text-red-600 hover:bg-red-600 hover:text-white shadow-md transition-all">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="bg-white p-5 rounded-2xl border border-[#BABABA] shadow-sm">
                <label class="block text-sm font-bold text-gray-700 mb-3">Product Status</label>
                <div class="space-y-2">
                    <label class="flex items-center gap-3 p-3 border border-[#bababa] rounded-xl cursor-pointer has-checked:border-[#CD2828] has-checked:bg-red-50 transition-all">
                        <input type="radio" name="status" value="active" class="accent-[#CD2828]" {{ $product->status == 'active' ? 'checked' : '' }}>
                        <span class="text-sm font-medium text-gray-700">Active</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 border border-[#BABABA] rounded-xl cursor-pointer has-checked:border-[#CD2828] has-checked:bg-red-50 transition-all">
                        <input type="radio" name="status" value="inactive" class="accent-[#CD2828]" {{ (old('status', $product->status ?? '') == 'inactive') ? 'checked' : '' }}>
                        <span class="text-sm font-medium">Inactive</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
<script>
    // 1. Variabel Global (Cukup tulis 1 kali saja Mas)
    let selectedFiles = [];

    // 2. FUNGSI PREVIEW FOTO BARU
    function handleMultipleFiles(input) {
        const files = Array.from(input.files);
        const container = document.getElementById('gallery_preview_container');
        
        console.log("Fungsi preview jalan, jumlah file:", files.length);

        files.forEach(file => {
            // Validasi ukuran (Max 2MB)
            if(file.size > 2 * 1024 * 1024) {
                alert(`File ${file.name} kegedean Mas! Maksimal 2MB.`);
                return;
            }

            selectedFiles.push(file);
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative group aspect-square rounded-lg border-2 border-[#CD2828] overflow-hidden shadow-md animate-fade-in';
                
                // Ambil index terakhir buat keperluan hapus preview
                const fileIndex = selectedFiles.length - 1;

                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover">
                    <div class="absolute top-0 left-0 bg-[#CD2828] text-white text-[8px] px-1 font-bold shadow">NEW</div>
                    <button type="button" onclick="removePreview(this, ${fileIndex})" class="absolute top-1 right-1 bg-black bg-opacity-50 text-white p-1 rounded-full hover:bg-red-600 transition-colors">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                `;
                container.appendChild(div);
            }
            reader.readAsDataURL(file);
        });

        // Reset input file biar bisa pilih file yang sama lagi kalau mau
        input.value = '';
    }

    // 3. FUNGSI HAPUS PREVIEW (Sebelum Update)
    function removePreview(btn, index) {
        selectedFiles.splice(index, 1);
        btn.parentElement.remove();
        console.log("Preview dihapus, sisa file baru:", selectedFiles.length);
    }

    // 4. FUNGSI HAPUS FOTO LAMA (AJAX ke Database)
    function deleteExistingImage(id) {
        if(confirm('Yakin mau hapus foto ini selamanya dari database?')) {
            fetch(`/admin/products/image/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    const el = document.getElementById(`old-image-${id}`);
                    el.classList.add('scale-0', 'opacity-0');
                    setTimeout(() => el.remove(), 300);
                }
            })
            .catch(err => {
                console.error(err);
                alert('Gagal hapus foto lama. Cek koneksi atau rute Mas.');
            });
        }
    }

    function submitProductForm() {
        // 1. Ambil elemen form
        const form = document.getElementById('productForm');
        if (!form) {
            alert("Waduh, ID productForm gak ketemu Mas!");
            return;
        }

        // 2. Bungkus semua input teks (name, sku, price, dll)
        const formData = new FormData(form);

        // 3. Masukkan file dari array selectedFiles (Galeri Preview)
        selectedFiles.forEach((file, index) => {
            formData.append('images[]', file);
        });

        // --- DEBUG: CEK ISI PAKET SEBELUM KIRIM ---
        console.log("Cek data yang mau dikirim:");
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]); 
        }
        // ------------------------------------------

        fetch(form.action, {
            method: "POST", 
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
            }
        })
        .then(async response => {
            const data = await response.json();
            if (response.ok) {
                alert('Mantap! Berhasil diperbarui.');
                window.location.href = "{{ route('admin.products.index') }}";
            } else {
                console.error("Validasi Gagal:", data.errors);
                alert('Gagal: ' + (data.message || 'Cek console F12 buat liat errornya.'));
            }
        })
        .catch(error => {
            console.error('Fatal Error:', error);
        });
    }
</script>