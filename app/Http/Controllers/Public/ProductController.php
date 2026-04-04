<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category; // Tambahkan ini
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Menampilkan semua produk & menangani Search
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = $request->q;

        $products = Product::where('status', 'active')
        ->whereHas('categories', function($q) use ($request) {
            if($request->q) {
                $q->where('name', 'like', "%{$request->q}%");
            }
        })
        ->orWhere('name', 'like', "%{$request->q}%")
        ->latest()
        ->paginate(12);

        $products = Product::where('status', 'active')
            ->when($query, function($q) use ($query) {
                return $q->where('name', 'like', "%$query%");
            })
            ->latest()
            ->paginate(12);

        

        return view('public.products.index', compact('products', 'categories'));
    }

    // Menampilkan produk berdasarkan Kategori (Fix Error Route tadi)
    public function category($slug)
    {
        $categories = Category::all();
        
        // 1. Cari kategorinya dulu berdasarkan slug
        $currentCategory = Category::where('slug', $slug)->firstOrFail();
        
        // 2. Ambil produk yang nyambung ke kategori ini lewat tabel pivot
        $products = Product::with('images')
            ->whereHas('categories', function($q) use ($currentCategory) {
                $q->where('categories.id', $currentCategory->id);
            })
            ->where('status', 'active')
            ->latest()
            ->paginate(12);

        $breadcrumbs = [
                [
                    'name' => 'Products', 
                    'url' => route('public.products') // Link ke Katalog
                ],
                [
                    'name' => $currentCategory->name, // Tetap tampilin nama RAM/Oli dll
                    'url' => route('public.products') // TAPI link-nya dipaksa ke Katalog Utama
                ],
            ];
        return view('public.products.index', compact('products', 'categories', 'currentCategory', 'breadcrumbs'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->with(['categories', 'images']) // Eager load biar gak berat
            ->firstOrFail();

        // Susun array breadcrumbs

        $breadcrumbs = [
                ['name' => 'Products', 'url' => route('public.products')],
            ];
        
            if ($product->categories->isNotEmpty()) {
                $breadcrumbs[] = [
                    'name' => $product->categories->first()->name, // Muncul tulisan "RAM"
                    'url' => route('public.products') // TAPI kalau diklik ke "/products"
                ];
            }
        
            $breadcrumbs[] = ['name' => $product->name, 'url' => null];
        
        
        return view('public.products.show', compact('product', 'breadcrumbs'));
    }
}