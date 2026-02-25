<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\StockHistory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);

        $totalProducts = Product::count();
        $emptyStock = Product::where('stock', 0)->count();
        $runningLow = Product::whereColumn('stock', '<', 'minimum_stock')->where('stock', '<', 0)->count();
        $safeStock = $totalProducts - $emptyStock - $runningLow;

        return view('staff.stock.index', compact('products', 'totalProducts', 'emptyStock', 'runningLow', 'safeStock'));
    }

    public function edit(Product $product)
    {
        return view('staff.stock.edit', compact('product'));
    }

    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer'
        ]);

        $product = Product::findOrFail($productId);

        DB::transaction(function () use ($product, $request) {

            $oldStock = $product->stock;
            $newStock = $oldStock + $request->quantity;

            $product->update([
                'stock' => $newStock
            ]);

            StockHistory::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'old_stock' => $oldStock,
                'new_stock' => $newStock,
                'change' => $request->quantity,
            ]);
        });

        return back()->with('success', 'Stock updated successfully.');
    }
}
