<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

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

        return view('staff.products.index', compact('products', 'totalProducts', 'activeProducts'));
    }

    public function show(Product $product)
    {        
        return view('staff.products.show', compact('product'));
    }
}
