<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', 1)->latest()->paginate(12);

        return view('products.index', compact('products'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', 1)
            ->firstOrFail();

        return view('products.show', compact('product'));
    }

    public function search(Request $request)
    {
        $query = $request->q;

        $products = Product::where('name', 'category_id', "%$query%")->get();

        return view('products.search', compact('products'));
    }
}
