@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-[#CD2828]">Product Categories</h1>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">
            Back to Products
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- FORM TAMBAH (Kiri) --}}
    <div class="bg-white p-6 rounded-2xl shadow-md border border-[#BABABA] h-fit">
        <h2 class="text-xl font-bold mb-6 text-gray-800">Add Category</h2>
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold mb-2">Category Name</label>
                <input type="text" name="name" class="w-full border border-[#BABABA] rounded-xl px-4 py-2 focus:border-[#CD2828] outline-none" placeholder="Ex: Spareparts" required>
            </div>

            <div>
                <label class="block text-sm font-bold mb-2">Ikon Kategori (Format PNG) <br> Flat Icon PNG Transparent (Flaticon)</label>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-[#CD2828] transition-all relative">
                    <input type="file" name="icon" id="icon_upload" class="hidden" accept=".svg,.png" onchange="previewImage(this)">
                    <label for="icon_upload" class="cursor-pointer flex flex-col items-center" id="placeholder">
                        <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round"/></svg>
                        <span class="text-xs text-gray-500">Upload Icon</span>
                    </label>
                    <div id="preview_container" class="hidden flex flex-col items-center">
                        <img id="img_preview" src="#" class="w-12 h-12 object-contain mb-2">
                        <span class="text-[10px] text-red-500 font-bold">Change Icon</span>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-[#CD2828] text-white font-bold py-3 rounded-xl hover:bg-[#832A2A] shadow-md transition-all">
                Save Category
            </button>
        </form>
    </div>

    {{-- TABEL LIST (Kanan) --}}
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-md border border-[#BABABA] overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-[#C4C4C4]">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-bold">Icon</th>
                    <th class="px-6 py-3 text-left text-sm font-bold">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#BABABA]">
                @foreach($categories as $cat)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center p-2">
                            @if($cat->icon)
                                <img src="{{ asset($cat->icon) }}?v={{ time() }} " class="max-w-full max-h-full object-contain">
                            @else
                                <span class="text-[8px] text-gray-400 italic">No Icon</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 font-bold uppercase text-sm">{{ $cat->name }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-3">
                            {{-- Tombol Edit --}}
                            <button type="button" 
                                onclick="openEditModal({{ $cat->id }}, '{{ $cat->name }}', '{{ $cat->icon ? asset($cat->icon) : '' }}')"
                                class="text-[#1BCFD5] font-bold hover:underline">
                                Edit
                            </button>
                    
                            <span class="text-gray-300">|</span>
                    
                            {{-- Tombol Delete --}}
                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-[#CD2828] font-bold hover:underline">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-3xl shadow-2xl border-2 border-black w-full max-w-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-black text-gray-800 uppercase">Edit Category</h2>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-black">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round"/></svg>
            </button>
        </div>

        <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-bold mb-2">Category Name</label>
                <input type="text" name="name" id="edit_name" class="w-full border-2 border-black rounded-xl px-4 py-3 focus:border-[#CD2828] outline-none font-bold" required>
            </div>

            <div>
                <label class="block text-sm font-bold mb-2 text-gray-600">Icon (SVG/PNG)</label>
                <div class="border-2 border-dashed border-black rounded-xl p-4 text-center hover:border-[#CD2828] transition-all relative bg-gray-50">
                    <input type="file" name="icon" id="edit_icon_upload" class="hidden" accept=".svg,.png" onchange="previewEditImage(this)">
                    <label for="edit_icon_upload" class="cursor-pointer flex flex-col items-center">
                        <div id="edit_preview_container" class="flex flex-col items-center">
                            <img id="edit_img_preview" src="#" class="w-16 h-16 object-contain mb-2">
                            <span class="text-[10px] text-[#CD2828] font-black uppercase tracking-widest">Click to Change Icon</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeEditModal()" class="flex-1 bg-gray-200 text-gray-700 font-bold py-3 rounded-xl hover:bg-gray-300">Cancel</button>
                <button type="submit" class="flex-1 bg-[#CD2828] text-white font-bold py-3 rounded-xl shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-y-1 hover:shadow-none transition-all">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Preview untuk Form Tambah (Sudah ada di kode sebelumnya)
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('placeholder').classList.add('hidden');
                document.getElementById('preview_container').classList.remove('hidden');
                document.getElementById('img_preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // --- LOGIKA EDIT MODAL ---
    function openEditModal(id, name, iconUrl) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');
        
        // PASTIIN URL INI BENAR SESUAI ROUTE RESOURCE
        form.action = `/admin/categories/${id}`;
        
        document.getElementById('edit_name').value = name;

        const imgPreview = document.getElementById('edit_img_preview');
        if (iconUrl && iconUrl !== '') {
            imgPreview.src = iconUrl;
        } else {
            imgPreview.src = 'https://via.placeholder.com/150?text=No+Icon';
        }

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function previewEditImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('edit_img_preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Tutup modal jika klik di luar box
    window.onclick = function(event) {
        const modal = document.getElementById('editModal');
        if (event.target == modal) {
            closeEditModal();
        }
    }
</script>
@endsection