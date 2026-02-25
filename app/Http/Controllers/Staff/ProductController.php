<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('staff.products.index', compact('products'));
    }

    public function show(Product $product)
    {        
        return view('staff.products.show', compact('product'));
    }
}
