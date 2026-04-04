<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $promoProducts = Product::with('images')->where('is_promo', true)
            ->where('status', 'active')
            ->latest()
            ->take(6)
            ->get();

        $bestSeller = Product::with('images')->orderBy('sold', 'desc')
            ->where('status', 'active')
            ->take(6)
            ->get();

        $products = Product::with('images') 
                ->where('status', 'active')
                ->latest()
                ->paginate(6);

        return view('public.index', compact(
            'categories',
            'promoProducts',
            'bestSeller',
            'products'
        ));
    }

    public function search(Request $request)
    {
        $keyword = $request->q;

        $products = Product::where('name', 'like', "%$keyword%")-get();

        return view('public.search', compact('products', 'keyword'));
    }

    public function allProducts()
    {
        $products = Product::latest()->paginate(12);
        $categories = Category::all();
        
        return view('public.products', compact('products', 'categories'));
    }

    public function category($slug)
    {
        $categories = Category::all();
        $currentCategory = Category::where('slug', $slug)->firstOrFail();
        
        // Ambil produk berdasarkan kategori yang dipilih
        $products = $currentCategory->products()->latest()->get();

        return view('public.products.index', compact('products', 'categories', 'currentCategory'));
    }
}