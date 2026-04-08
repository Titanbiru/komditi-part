<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request) // Tambahkan Request $request
    {
        // Gunakan 'status' sesuai database products, bukan 'is_active'
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', 'active')->count();

        $query = Product::with('categories')->latest();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->paginate(10);

        return view('admin.products.index', compact('products', 'totalProducts', 'activeProducts'));
    }


    public function show(Product $product)
    {        
        return view('admin.products.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'sku'          => 'required|string|max:100|unique:products,sku',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'category_ids' => 'required|array', 
            'category_ids.*' => 'exists:categories,id',
            'images'       => 'nullable|array|max:5',
            'images.*'     => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'       => 'required|in:active,inactive',
            
        ]);

        // Simpan Produk (Price disimpan harga asli dari input)
        $product = Product::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'sku'         => $request->sku,
            'price'       => $request->price, // Harga asli
            'discount'    => $request->discount ?? 0,
            'stock'       => $request->stock,
            'weight'      => $request->weight,
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        // Hubungkan ke banyak kategori
        $product->categories()->sync($request->category_ids);

        // Simpan Banyak Gambar (Galeri)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        // Response khusus untuk Fetch/AJAX
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Produk berhasil dibuat']);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {   
        $request->validate([
            'name'         => 'required|string|max:255',
            'sku'          => 'required|string|max:100|unique:products,sku,' . $product->id,
            'price'        => 'required|numeric|min:0',
            'stock'        => 'nullable|integer|min:0',
            'weight'       => 'nullable|numeric|min:0',
            'category_ids' => 'required|array',
            'description'  => 'nullable|string',
            'images'       => 'nullable|array|max:5',
            'images.*'     => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'       => 'required|in:active,inactive',
            'is_promo'     => 'nullable|boolean'
        ]);

        $product->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'sku'         => $request->sku,
            'price'       => $request->price, // Update harga asli
            'discount'    => $request->discount ?? 0,
            'is_promo'    => $request->boolean('is_promo'),
            'stock'       => $request->stock ?? $product->stock, // Tetap gunakan stok lama jika null
            'weight'      => $request->weight,
            'description' => $request->description,
            'status'      => (string) $request->status,
        ]);
        
        // 2. Sinkronisasi Kategori
        $product->categories()->sync($request->category_ids);

        // 3. Tambah Foto Baru
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        // Response JSON untuk Fetch di Blade
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diperbarui!'
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function history(Product $product)
    {
        $histories = $product->stockHistories()->with('user')->latest()->paginate(10);

        return view('admin.stock.history', compact('product', 'histories'));
    }

    public function deleteImage($id)
    {
        // Cari data gambarnya
        $image = \App\Models\ProductImage::findOrFail($id);

        // 1. Hapus File Fisik dari Storage
        if (\Storage::disk('public')->exists($image->image_path)) {
            \Storage::disk('public')->delete($image->image_path);
        }

        // 2. Hapus Data dari Database
        $image->delete();

        // Balikin respon JSON (Bagus buat AJAX)
        return response()->json(['success' => true, 'message' => 'Foto berhasil dihapus!']);
    }

    public function destroy($id) // Pakai $id dulu biar gak ribet sama binding
{
    $product = Product::find($id);

    if (!$product) {
        return back()->with('error', 'Produk gak ketemu di database Mas!');
    }

    try {
        // Hapus relasi gambar
        $product->images()->delete();
        
        // Putus kategori
        $product->categories()->detach();

        // Hapus Produk
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Berhasil dihapus!');
    } catch (\Exception $e) {
        // Kalau gagal karena database ngunci, ini bakal muncul
        dd("Gagal hapus karena: " . $e->getMessage());
    }
}
}
