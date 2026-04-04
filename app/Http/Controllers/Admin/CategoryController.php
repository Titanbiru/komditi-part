<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; 

class CategoryController extends Controller
{
    public function index()
    {
        // Mengambil semua kategori untuk ditampilkan di tabel
        $categories = Category::latest()->get();
        
        // Mengarahkan ke file resources/views/admin/categories/index.blade.php
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:categories,name',
        'icon' => 'nullable|image|mimes:svg,svg+xml,png,jpg,jpeg|max:2048',
    ]);

    $category = new Category();
    $category->name = $request->name;
    $category->slug = Str::slug($request->name);

    if ($request->hasFile('icon')) {
        $file = $request->file('icon');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $tujuan = public_path('uploads/categories');

        if (!File::isDirectory($tujuan)) {
            File::makeDirectory($tujuan, 0777, true, true);
        }

        $file->move($tujuan, $namaFile);
        $category->icon = 'uploads/categories/' . $namaFile;
    }

    $category->save();
    return back()->with('success', 'Kategori Berhasil!');
}

    public function update(Request $request, $id)
{
    $category = Category::findOrFail($id);

    $request->validate([
        'name' => 'required|unique:categories,name,' . $id,
        'icon' => 'nullable|image|mimes:svg,xml,png,jpg,jpeg|max:2048',
    ]);

    $category->name = $request->name;
    $category->slug = \Illuminate\Support\Str::slug($request->name);

    if ($request->hasFile('icon')) {
        $file = $request->file('icon');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        
        // Simpan ke: public/uploads/categories
        $tujuan = public_path('uploads/categories');

        // 1. Cek & Buat folder kalau belum ada
        if (!File::isDirectory($tujuan)) {
            File::makeDirectory($tujuan, 0777, true, true);
        }

        // 2. Hapus Ikon Lama (biar storage laptop gak penuh)
        if ($category->icon) {
            $pathLama = public_path($category->icon);
            if (File::exists($pathLama)) {
                File::delete($pathLama);
            }
        }

        // 3. Pindahkan file baru
        $file->move($tujuan, $namaFile);
        
        // 4. Simpan path baru ke database
        $category->icon = 'uploads/categories/' . $namaFile;
    }

    $category->save();

    return back()->with('success', 'Kategori berhasil diperbarui!');
}

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if ($category->icon && Storage::disk('public')->exists($category->icon)) {
            Storage::disk('public')->delete($category->icon);
        }
        
        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}