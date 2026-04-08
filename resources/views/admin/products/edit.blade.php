@extends('layouts.admin')

@section('content')
<form action="{{ route('admin.products.update', $product) }}" id="productForm" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- HEADER ACTION --}}
    <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 px-2">
        <div>
            <h1 class="text-3xl font-black text-[#CD2828] uppercase tracking-tighter">Edit Product</h1>
            <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Modify specifications for: {{ $product->name }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.products.index') }}" class="bg-[#F9F9F9] text-[#BABABA] px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#202020] hover:text-white transition-all">Back</a>
            <button type="button" onclick="submitProductForm()" class="bg-[#CD2828] text-white px-10 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#202020] transition-all shadow-lg active:scale-95">
                Update Changes
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 pb-20">
        {{-- LEFT COLUMN: PRODUCT DATA --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-8 shadow-sm space-y-6">
                <div>
                    <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Product Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required 
                        class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-4 text-[11px] font-black uppercase text-[#202020] outline-none focus:ring-1 focus:ring-[#CD2828]">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">SKU Product</label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required 
                            class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-4 text-[11px] font-black text-[#202020] outline-none">
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Promo Status</label>
                        <label class="flex items-center gap-3 p-4 rounded-2xl bg-[#F9F9F9] cursor-pointer has-[:checked]:bg-[#CD2828] has-[:checked]:text-white transition-all group">
                            <input type="hidden" name="is_promo" value="0">
                            <input type="checkbox" name="is_promo" value="1" {{ old('is_promo', $product->is_promo) ? 'checked' : '' }} class="hidden">
                            <div class="w-5 h-5 border-2 border-[#BABABA] group-has-[:checked]:border-white rounded flex items-center justify-center">
                                <div class="w-2.5 h-2.5 bg-white scale-0 group-has-[:checked]:scale-100 transition-transform"></div>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-widest">Aktifkan Promo Highlight</span>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Price</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" required 
                            class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-4 text-[11px] font-black text-[#202020] outline-none">
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Discount (%)</label>
                        <input type="number" name="discount" value="{{ old('discount', $product->discount ?? 0) }}" 
                            class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-4 text-[11px] font-black text-[#CD2828] outline-none">
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Stock</label>
                        <input type="number" value="{{ $product->stock }}" readonly 
                            class="w-full bg-gray-100 border-none rounded-2xl px-5 py-4 text-[11px] font-black text-[#BABABA] outline-none cursor-not-allowed" title="Update stock via Inbound menu">
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Weight (KG)</label>
                        <input type="number" step="0.01" name="weight" value="{{ old('weight', $product->weight) }}" required 
                            class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-4 text-[11px] font-black text-[#202020] outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Description</label>
                    <textarea name="description" rows="6" class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-4 text-[11px] font-medium text-[#202020] outline-none focus:ring-1 focus:ring-[#CD2828]">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            {{-- CATEGORY SELECTION --}}
            <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-8 shadow-sm">
                <label class="block text-[9px] font-black text-[#BABABA] uppercase tracking-widest mb-6 ml-1">Classification Categories</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 max-h-[200px] overflow-y-auto custom-scrollbar pr-2">
                    @foreach($categories as $cat)
                        <label class="flex items-center gap-3 p-4 rounded-2xl border border-[#BABABA]/5 bg-[#F9F9F9] hover:bg-red-50 cursor-pointer transition-all group has-[:checked]:bg-[#202020] has-[:checked]:text-white">
                            <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}" 
                                {{ $product->categories->contains($cat->id) ? 'checked' : '' }} class="hidden">
                            <span class="text-[10px] font-black uppercase tracking-tight group-hover:text-[#CD2828] group-has-[:checked]:text-[#1BCFD5]">
                                {{ $cat->name }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: STATUS & GALLERY --}}
        <div class="space-y-6">
            {{-- STATUS --}}
            <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-8 shadow-sm">
                <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-4 ml-1 tracking-widest">Visibility Status</label>
                <div class="flex flex-col gap-2">
                    <label class="flex items-center gap-3 p-4 rounded-2xl bg-[#F9F9F9] cursor-pointer has-[:checked]:bg-[#1BCFD5] has-[:checked]:text-white transition-all">
                        <input type="radio" name="status" value="active" class="hidden" {{ $product->status == 'active' ? 'checked' : '' }}>
                        <span class="text-[10px] font-black uppercase tracking-widest">Active Stock</span>
                    </label>
                    <label class="flex items-center gap-3 p-4 rounded-2xl bg-[#F9F9F9] cursor-pointer has-[:checked]:bg-[#CD2828] has-[:checked]:text-white transition-all">
                        <input type="radio" name="status" value="inactive" class="hidden" {{ $product->status == 'inactive' ? 'checked' : '' }}>
                        <span class="text-[10px] font-black uppercase tracking-widest">Inactive / Hide</span>
                    </label>
                </div>
            </div>

            {{-- GALLERY --}}
            <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-8 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <label class="text-[9px] font-black text-[#BABABA] uppercase tracking-widest ml-1">Asset Gallery</label>
                    <label for="multi_image_input" class="cursor-pointer bg-[#F9F9F9] text-[#202020] p-2 rounded-xl hover:bg-[#CD2828] hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                        <input type="file" name="images[]" id="multi_image_input" class="hidden" accept="image/*" multiple onchange="handleMultipleFiles(this)">
                    </label>
                </div>

                {{-- NEW PHOTOS PREVIEW --}}
                <div id="gallery_preview_container" class="grid grid-cols-2 gap-2 min-h-[50px] mb-4"></div>

                {{-- EXISTING PHOTOS --}}
                @if($product->images->count() > 0)
                <div class="pt-4 border-t border-[#F9F9F9]">
                    <p class="text-[8px] font-black text-[#BABABA] uppercase mb-3 tracking-widest">Existing Assets</p>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($product->images as $img)
                            <div class="relative aspect-square rounded-xl bg-[#F9F9F9] overflow-hidden group" id="old-image-{{ $img->id }}">
                                <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover">
                                <button type="button" onclick="deleteExistingImage({{ $img->id }})" class="absolute inset-0 bg-[#CD2828]/80 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</form>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f9f9f9; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #CD2828; border-radius: 10px; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fadeIn 0.3s ease-out; }
</style>

<script>
    let selectedFiles = [];

    function handleMultipleFiles(input) {
        const files = Array.from(input.files);
        const container = document.getElementById('gallery_preview_container');
        
        files.forEach(file => {
            if(file.size > 2 * 1024 * 1024) {
                alert(`File ${file.name} kegedean Mas! Maksimal 2MB.`);
                return;
            }
            selectedFiles.push(file);
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative aspect-square rounded-xl border-2 border-[#1BCFD5] overflow-hidden shadow-md animate-fade-in group';
                const fileIndex = selectedFiles.length - 1;
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover">
                    <div class="absolute top-0 left-0 bg-[#1BCFD5] text-white text-[7px] px-1.5 font-black uppercase">New</div>
                    <button type="button" onclick="removePreview(this, ${fileIndex})" class="absolute inset-0 bg-[#202020]/80 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                `;
                container.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
        input.value = '';
    }

    function removePreview(btn, index) {
        selectedFiles.splice(index, 1);
        btn.parentElement.remove();
    }

    function deleteExistingImage(id) {
        if(confirm('Hapus foto ini selamanya dari database?')) {
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
            .catch(err => { alert('Gagal hapus foto lama.'); });
        }
    }

    function submitProductForm() {
        const form = document.getElementById('productForm');
        const formData = new FormData(form);
        const btn = event.target;
        
        btn.innerText = 'PROCESSING...';
        btn.disabled = true;

        selectedFiles.forEach((file) => {
            formData.append('images[]', file);
        });

        fetch(form.action, {
            method: "POST", // Method Spoofing Handle by FormData & @method('PUT')
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(async response => {
            const data = await response.json();
            if (response.ok) {
                alert('Update Berhasil!');
                window.location.href = "{{ route('admin.products.index') }}";
            } else {
                btn.innerText = 'UPDATE CHANGES';
                btn.disabled = false;
                alert('Gagal: ' + (data.message || 'Cek kembali data Mas.'));
            }
        })
        .catch(error => {
            btn.innerText = 'UPDATE CHANGES';
            btn.disabled = false;
            console.error('Fatal Error:', error);
        });
    }
</script>
@endsection 