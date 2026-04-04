@extends('layouts.admin')

@section('content')
<form action="{{ isset($product)  ? route('admin.products.update', $product) : route('admin.products.store') }}" id="productForm" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($product)) @method('PUT') @endif

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-[#CD2828]">{{ isset($product) ? 'Edit Product' : 'Add New Product' }}</h1>
        <div class="flex gap-3">
            <a href="{{ route('admin.products.index') }}" class="px-6 py-2 border border-[#BABABA] rounded-lg font-medium hover:bg-gray-50 transition-colors">
                Back
            </a>
            <button type="submit" onclick="submitProductForm()" class="px-6 py-2 bg-[#CD2828] text-white rounded-lg font-medium hover:bg-[#832A2A] transition-colors shadow-lg">
                {{ isset($product) ? 'Update Product' : 'Save Product' }}
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
        <div class="md:col-span-2 space-y-6">
            <div>
                <label class="block text-sm font-medium mb-2">Product Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="w-full border border-[#BABABA] rounded-xl px-4 py-3 focus:border-[#CD2828] outline-none" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">SKU Product</label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" class="w-full border border-[#BABABA] rounded-xl px-4 py-3 focus:border-[#CD2828] outline-none" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Price</label>
                    <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}" class="w-full border border-[#BABABA] rounded-xl px-4 py-3 focus:border-[#CD2828] outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Discount (%)</label>
                    <input type="number" name="discount" value="{{ old('discount', $product->discount ?? 0) }}" class="w-full border border-[#BABABA] rounded-xl px-4 py-3 focus:border-[#CD2828] outline-none">
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-2xl border border-[#BABABA] shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Category Selection</label>
                        <p class="text-[10px] text-gray-500 italic">*Select one or more categories</p>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border-2 border-[#E5E5E5] shadow-sm">
                    <div class="flex justify-between items-center mb-3">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider">Category Selection</label>
                        <span class="text-[10px] text-gray-400 font-medium">Scroll to see more</span>
                    </div>

                    {{-- Kuncinya ada di 'max-h-[220px]' dan 'overflow-y-auto' --}}
                    <div id="category_container" class="grid grid-cols-1 gap-3 p-2 max-h-[220px] overflow-y-auto custom-scrollbar pr-2">
                        @foreach($categories as $cat)
                            <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-[#CD2828] hover:bg-red-50 cursor-pointer transition-all group shadow-sm bg-gray-50/50">
                                <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}" 
                                    {{ (isset($product) && $product->categories->contains($cat->id)) ? 'checked' : '' }}
                                    class="accent-[#CD2828] w-5 h-5 rounded-md border-gray-300 focus:ring-0">
                                
                                <span class="text-sm font-semibold text-gray-600 group-hover:text-[#CD2828] uppercase tracking-tight">
                                    {{ $cat->name }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Description</label>
                <textarea name="description" rows="5" class="w-full border border-[#BABABA] rounded-xl px-4 py-3 focus:border-[#CD2828] outline-none" placeholder="Tuliskan detail produk di sini...">{{ old('description', $product->description ?? '') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Stock</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock ?? '') }}" class="w-full border border-[#BABABA] rounded-xl px-4 py-3 focus:border-[#CD2828] outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Weight (*kg)</label>
                    <input type="text" name="weight" value="{{ old('weight', $product->weight ?? '') }}" class="w-full border border-[#BABABA] rounded-xl px-4 py-3 focus:border-[#CD2828] outline-none" placeholder="0.5">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Status</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 border border-[#BABABA] rounded-full px-6 py-2 cursor-pointer has-[:checked]:border-[#CD2828] has-[:checked]:bg-red-50 transition-all">
                        <input type="radio" name="status" value="active" class="accent-[#CD2828]" {{ (old('status', $product->status ?? 'active') == 'active') ? 'checked' : '' }}>
                        <span class="text-sm font-medium">Active</span>
                    </label>
                    <label class="flex items-center gap-2 border border-[#BABABA] rounded-full px-6 py-2 cursor-pointer has-[:checked]:border-[#CD2828] has-[:checked]:bg-red-50 transition-all">
                        <input type="radio" name="status" value="inactive" class="accent-[#CD2828]" {{ (old('status', $product->status ?? '') == 'inactive') ? 'checked' : '' }}>
                        <span class="text-sm font-medium">Nonactive</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-gray-50 p-5 rounded-2xl border border-[#BABABA] shadow-sm">
                <div class="flex justify-between items-center mb-3">
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Product Gallery</label>
                        <p class="text-[10px] text-gray-500 italic">*Upload up to 5 images, Max 2MB each</p>
                    </div>
                    <label for="multi_image_input" class="cursor-pointer bg-white border border-[#CD2828] text-[#CD2828] p-2 rounded-lg hover:bg-red-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <input type="file" name="images[]" id="multi_image_input" class="hidden" accept="image/*" multiple onchange="handleMultipleFiles(this)">
                    </label>
                </div>

                <div id="gallery_preview_container" class="grid grid-cols-4 gap-2 min-h-[100px] border-2 border-dashed border-[#BABABA] rounded-xl p-2 bg-white shadow-inner">
                    <div id="gallery_empty_msg" class="col-span-4 flex flex-col items-center justify-center py-6 text-gray-400">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="text-xs font-medium">No images uploaded</span>
                    </div>
                </div>

                @if(isset($product) && $product->images->count() > 0)
                <div class="mt-4">
                    <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-widest">Current Gallery</label>
                    <div class="grid grid-cols-5 gap-2">
                        @foreach($product->images as $img)
                            <div class="relative aspect-square rounded-lg border border-gray-200 overflow-hidden" id="old-image-{{ $img->id }}">
                                <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover cursor-pointer" onclick="openZoomModal(this.src)">
                                <button type="button" onclick="deleteExistingImage({{ $img->id }})" class="absolute top-1 right-1 bg-white p-1 rounded-full text-red-600 shadow-sm hover:bg-red-600 hover:text-white transition-colors">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div id="image_zoom_modal" class="hidden fixed inset-0 bg-black bg-opacity-90 z-[999] flex items-center justify-center p-4 animate-fade-in" onclick="closeZoomModal()">
            <button class="absolute top-4 right-4 text-white hover:text-[#CD2828]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <img id="zoomed_image_src" src="" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
        </div>
    </div>
</form>
@endsection

<script>
    function toggleQuickCat() {
        const wrapper = document.getElementById('quick-cat-wrapper');
        wrapper.classList.toggle('hidden');
        if (!wrapper.classList.contains('hidden')) {
            document.getElementById('new_cat_name').focus();
        }
    }


    // === LOGIKA MULTIPLE IMAGE GALLERY & PREVIEW ===
    let selectedFiles = []; // Array untuk nampung file asli (buat diupload nanti)

    function handleMultipleFiles(input) {
        const files = Array.from(input.files);
        const container = document.getElementById('gallery_preview_container');
        const emptyMsg = document.getElementById('gallery_empty_msg');

        // Batasi maksimal 5 file total
        if (selectedFiles.length + files.length > 5) {
            alert('Maksimal 5 foto aja Mas, biar gak kegedean datanya.');
            input.value = ''; // Reset input
            return;
        }

        emptyMsg.classList.add('hidden'); // Sembunyikan pesan kosong

        files.forEach(file => {
            // Validasi per file (Max 2MB)
            if(file.size > 2 * 1024 * 1024) {
                alert(`File ${file.name} kegedean (>2MB). Dilewati ya Mas.`);
                return; // Skip file ini
            }

            // Tambahkan file valid ke array utama
            selectedFiles.push(file);

            // Buat FileReader untuk baca gambar (Preview)
            const reader = new FileReader();
            reader.onload = function(e) {
                // Buat struktur Thumbnail pakai JS
                const div = document.createElement('div');
                div.className = 'relative group aspect-square rounded-lg border border-[#BABABA] overflow-hidden shadow-sm animate-fade-in';
                
                // Index unik buat hapus nanti
                const fileIndex = selectedFiles.length - 1;

                div.innerHTML = `
                    <img src="${e.target.result}" 
                        class="w-full h-full object-cover cursor-pointer transition-transform group-hover:scale-110"
                        onclick="openZoomModal('${e.target.result}')">
                    
                    <div class="absolute inset-0 bg-[#CD2828] bg-opacity-70 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer" onclick="openZoomModal('${e.target.result}')">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                    </div>

                    <button type="button" onclick="removeImageFromGallery(${fileIndex}, this)" 
                        class="absolute top-1 right-1 bg-white p-0.5 rounded-full text-gray-500 hover:text-[#CD2828] shadow-md z-10">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                `;
                container.appendChild(div);
            }
            reader.readAsDataURL(file);
        });

        // PENTING: Reset input value agar bisa milih file yang sama lagi
        input.value = '';
    }

    // Fungsi Hapus Gambar dari Preview & Array
    function removeImageFromGallery(index, buttonEl) {
        // Hapus dari Array selectedFiles
        selectedFiles.splice(index, 1);
        
        // Hapus Element dari HTML
        const thumbnailDiv = buttonEl.closest('.relative');
        thumbnailDiv.classList.add('opacity-0', 'scale-75'); // Efek animasi hapus
        setTimeout(() => {
            thumbnailDiv.remove();
            
            // Tampilkan pesan kosong lagi kalau habis
            if (selectedFiles.length === 0) {
                document.getElementById('gallery_empty_msg').classList.remove('hidden');
            }
        }, 300);
    }

    function deleteExistingImage(id) {
        if(confirm('Hapus foto ini dari galeri?')) {
            fetch(`/admin/products/image/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(res => res.json()).then(data => {
                if(data.success) document.getElementById(`old-image-${id}`).remove();
            });
        }
    }

    // === LOGIKA MODAL ZOOM (Lightbox) ===
    function openZoomModal(imgSrc) {
        const modal = document.getElementById('image_zoom_modal');
        const zoomedImg = document.getElementById('zoomed_image_src');
        
        zoomedImg.src = imgSrc; // Pasang sumber gambar besar
        modal.classList.remove('hidden'); // Munculkan modal
        document.body.style.overflow = 'hidden'; // Matikan scroll body utama
    }

    function closeZoomModal() {
        const modal = document.getElementById('image_zoom_modal');
        modal.classList.add('hidden'); // Sembunyikan modal
        document.body.style.overflow = ''; // Aktifkan scroll body lagi
    }

    // Tutup pakai tombol ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeZoomModal();
        }
    });

    function submitProductForm() {
        const form = document.getElementById('productForm'); // Pastikan ambil lewat ID
        const formData = new FormData(form);

        // Ambil Token CSRF langsung dari form
        const token = form.querySelector('input[name="_token"]').value;

        // Masukkan file-file gambar dari array selectedFiles
        selectedFiles.forEach((file) => {
            formData.append('images[]', file);
        });

        // Kita kasih visual loading dikit biar user gak klik berkali-kali
        const btn = event.target;
        const originalText = btn.innerText;
        btn.innerText = 'Processing...';
        btn.disabled = true;

        fetch(form.action, {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': token, // Masukkan token ke Header
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async response => {
            if (response.status === 419) {
                alert('Sesi habis Mas, halamannya akan otomatis refresh ya.');
                location.reload();
                return;
            }

            const data = await response.json();
            if (response.ok) {
                alert('Mantap Mas! Produk berhasil disimpan.');
                window.location.href = "{{ route('admin.products.index') }}";
            } else {
                btn.innerText = originalText;
                btn.disabled = false;
                alert('Gagal: ' + (data.message || 'Cek kembali inputan Mas.'));
                console.log(data.errors);
            }
        })
        .catch(error => {
            btn.innerText = originalText;
            btn.disabled = false;
            console.error('Error:', error);
            alert('Terjadi kesalahan koneksi/server.');
        });
    }
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #CD2828;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #832A2A;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 5px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #CD2828; 
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #832A2A; 
    }
</style>