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
            // Kita tampilkan SEMUA yang active, berapapun stoknya
            ->when($query, function($q) use ($query) {
                return $q->where(function($sub) use ($query) {
                    $sub->where('name', 'like', "%$query%")
                        ->orWhereHas('categories', function($cat) use ($query) {
                            $cat->where('name', 'like', "%$query%");
                        });
                });
            })
            ->with(['images', 'categories'])
            ->latest()
            ->paginate(12);

        return view('public.products.index', compact('products', 'categories'));
    }

    public function category($slug)
    {
        $categories = Category::all();
        $currentCategory = Category::where('slug', $slug)->firstOrFail();
        
        $products = Product::with('images')
            ->where('status', 'active') // Stok 0 tetap muncul di kategori
            ->whereHas('categories', function($q) use ($currentCategory) {
                $q->where('categories.id', $currentCategory->id);
            })
            ->latest()
            ->paginate(12);

        $breadcrumbs = [
            ['name' => 'Products', 'url' => route('public.products')],
            ['name' => $currentCategory->name, 'url' => route('public.products')],
        ];

        return view('public.products.index', compact('products', 'categories', 'currentCategory', 'breadcrumbs'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['images', 'category'])
            // Tambahkan ini: Hitung total quantity dari relasi orderItems
            ->withCount(['orderItems as sold_count' => function($query) {
                $query->whereHas('order', function($q) {
                    $q->where('payment_status', 'paid'); // Hanya hitung yang sudah lunas
                });
            }])
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