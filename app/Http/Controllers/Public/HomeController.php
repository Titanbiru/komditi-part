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

        $promoProducts = Product::where('is_promo', true)
            ->latest()
            ->take(6)
            ->get();

        $bestSeller = Product::orderBy('sold', 'desc')
            ->take(6)
            ->get();

        return view('public.index', compact(
            'categories',
            'promoProducts',
            'bestSeller'
        ));
    }

    public function search(Request $request)
    {
        $keyword = $request->q;

        $products = Product::where('name', 'like', "%$keyword%")-get();

        return view('public.search', compact('products', 'keyword'));
    }
}