@extends('layouts.admin')

@section('content')
{{-- HEADER --}}
<div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 px-2">
    <div>
        <h1 class="text-3xl font-black text-[#CD2828] uppercase tracking-tighter">Product Categories</h1>
        <p class="text-[10px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Classify your inventory for better discovery</p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="bg-[#F9F9F9] text-[#BABABA] px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#202020] hover:text-white transition-all">
        Back to Products
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-20">
    {{-- FORM TAMBAH (Kiri) --}}
    <div class="lg:col-span-1">
        <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] p-8 shadow-sm sticky top-24">
            <div class="flex items-center gap-3 mb-8">
                <span class="w-1 h-4 bg-[#CD2828] rounded-full"></span>
                <h2 class="text-[11px] font-black text-[#202020] uppercase tracking-[0.2em]">Add New Category</h2>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Category Name</label>
                    <input type="text" name="name" required placeholder="Ex: Spareparts"
                        class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-4 text-[11px] font-black uppercase text-[#202020] outline-none focus:ring-1 focus:ring-[#CD2828]">
                </div>

                <div>
                    <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Category Icon (PNG/SVG)</label>
                    <div class="group relative bg-[#F9F9F9] rounded-2xl border-2 border-dashed border-[#BABABA]/10 p-6 text-center hover:border-[#CD2828]/30 transition-all">
                        <input type="file" name="icon" id="icon_upload" class="hidden" accept=".svg,.png" onchange="previewImage(this)">
                        
                        <label for="icon_upload" class="cursor-pointer flex flex-col items-center" id="placeholder">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm mb-2 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-[#CD2828]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="3" stroke-linecap="round"/></svg>
                            </div>
                            <span class="text-[8px] font-black text-[#BABABA] uppercase tracking-widest">Select Asset</span>
                        </label>

                        <div id="preview_container" class="hidden flex flex-col items-center">
                            <img id="img_preview" src="#" class="w-16 h-16 object-contain mb-2 drop-shadow-sm">
                            <span class="text-[7px] font-black text-[#CD2828] uppercase underline tracking-widest">Change Icon</span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#202020] text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-[#CD2828] transition-all shadow-lg active:scale-95">
                    Save Category
                </button>
            </form>
        </div>
    </div>

    {{-- TABEL LIST (Kanan) --}}
    <div class="lg:col-span-2">
        <div class="bg-white border border-[#BABABA]/20 rounded-[2.5rem] overflow-hidden shadow-sm">
            <table class="w-full text-left">
                <thead class="bg-[#F3F3F3] border-b-2 border-white text-[9px] font-black uppercase tracking-widest text-[#202020]">
                    <tr>
                        <th class="p-6 text-center border-r border-white" width="80">Icon</th>
                        <th class="p-6 border-r border-white">Classification Name</th>
                        <th class="p-6 text-center" width="150">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#BABABA]/10 text-[11px] font-bold uppercase text-[#202020]">
                    @forelse($categories as $cat)
                    <tr class="hover:bg-[#F9F9F9] transition-colors group">
                        <td class="p-4 text-center">
                            <div class="w-12 h-12 bg-[#F9F9F9] rounded-xl flex items-center justify-center p-2 mx-auto border border-[#BABABA]/5 group-hover:bg-white transition-all">
                                @if($cat->icon)
                                    <img src="{{ asset($cat->icon) }}?v={{ time() }}" class="max-w-full max-h-full object-contain">
                                @else
                                    <span class="text-[7px] text-[#BABABA] italic leading-none">N/A</span>
                                @endif
                            </div>
                        </td>
                        <td class="p-6 font-black tracking-tight">{{ $cat->name }}</td>
                        <td class="p-6 text-center">
                            <div class="flex justify-center gap-6 text-[9px] font-black tracking-widest">
                                <button type="button" 
                                    onclick="openEditModal({{ $cat->id }}, '{{ $cat->name }}', '{{ $cat->icon ? asset($cat->icon) : '' }}')"
                                    class="text-[#1BCFD5] hover:underline">EDIT</button>
                                
                                <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-[#CD2828] hover:underline">PURGE</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-10 text-center text-[#BABABA] text-[10px] font-black uppercase tracking-widest italic">No categories mapped yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL EDIT (Ultra Clean) --}}
<div id="editModal" class="fixed inset-0 bg-[#202020]/40 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4 transition-all">
    <div class="bg-white p-10 rounded-[3rem] shadow-2xl border border-white/20 w-full max-w-md scale-95 transition-transform duration-300" id="modalContent">
        <div class="flex justify-between items-start mb-8">
            <div>
                <h2 class="text-2xl font-black text-[#202020] uppercase tracking-tighter">Edit Label</h2>
                <p class="text-[9px] font-bold text-[#BABABA] uppercase tracking-widest mt-1">Adjusting category specifications</p>
            </div>
            <button onclick="closeEditModal()" class="text-[#BABABA] hover:text-[#CD2828] p-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="3" stroke-linecap="round"/></svg>
            </button>
        </div>

        <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Updated Name</label>
                <input type="text" name="name" id="edit_name" required
                    class="w-full bg-[#F9F9F9] border-none rounded-2xl px-5 py-4 text-[11px] font-black uppercase text-[#202020] outline-none focus:ring-1 focus:ring-[#CD2828]">
            </div>

            <div>
                <label class="block text-[9px] font-black text-[#BABABA] uppercase mb-2 ml-1 tracking-widest">Replacement Icon</label>
                <div class="bg-[#F9F9F9] rounded-2xl border border-[#BABABA]/10 p-6 text-center">
                    <input type="file" name="icon" id="edit_icon_upload" class="hidden" accept=".svg,.png" onchange="previewEditImage(this)">
                    <label for="edit_icon_upload" class="cursor-pointer flex flex-col items-center">
                        <div id="edit_preview_container" class="flex flex-col items-center group">
                            <img id="edit_img_preview" src="#" class="w-20 h-20 object-contain mb-4 drop-shadow-md group-hover:scale-105 transition-transform">
                            <span class="text-[8px] font-black text-[#CD2828] uppercase underline tracking-[0.2em]">Upload New Asset</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeEditModal()" class="flex-1 bg-[#F9F9F9] text-[#BABABA] py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-100 transition-all">Cancel</button>
                <button type="submit" class="flex-1 bg-[#202020] text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-[#CD2828] transition-all shadow-lg">Commit Change</button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes modalEnter { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
    .modal-active #modalContent { animation: modalEnter 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
</style>

<script>
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

    function openEditModal(id, name, iconUrl) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');
        form.action = `/admin/categories/${id}`;
        document.getElementById('edit_name').value = name;

        const imgPreview = document.getElementById('edit_img_preview');
        imgPreview.src = iconUrl && iconUrl !== '' ? iconUrl : 'https://via.placeholder.com/150?text=No+Icon';

        modal.classList.remove('hidden');
        modal.classList.add('flex', 'modal-active');
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex', 'modal-active');
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

    window.onclick = function(event) {
        if (event.target == document.getElementById('editModal')) closeEditModal();
    }
</script>
@endsection