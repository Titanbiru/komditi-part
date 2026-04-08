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
        
        // 1. Stok yang benar-benar 0
        $emptyStock = Product::where('stock', 0)->count();
        
        // 2. Stok yang menipis (antara 1 sampai 5)
        // Pakai where, bukan whereColumn!
        $runningLow = Product::where('stock', '>', 0)->where('stock', '<', 5)->count();
        
        // 3. Stok aman (diatas atau sama dengan 5)
        $safeStock = Product::where('stock', '>=', 5)->count();

        return view('staff.stock.index', compact('products', 'totalProducts', 'emptyStock', 'runningLow', 'safeStock'));
    }

    public function edit(Product $product)
    {
        return view('staff.stock.edit', compact('product'));
    }

    public function update(Request $request, $productId)
    {
        $request->validate([
            'amount' => 'required|integer|min:1',
            'type' => 'required|in:in,out',
            'note' => 'nullable|string',
        ]);

        $product = Product::findOrFail($productId);

        try {
                
            DB::transaction(function () use ($product, $request) {

                $change = ($request->type == 'in') ? $request->amount : -$request->amount;

                $oldStock = $product->stock;
                $newStock = $oldStock + $change;

                if ($newStock < 0) {
                    throw new \Exception('Stok saat ini (' . $oldStock . ') tidak mencukupi untuk dikurangi sebanyak ' . $request->amount . '.');
                }
                $product->update([
                    'stock' => $newStock
                ]);

                StockHistory::create([
                    'product_id' => $product->id,
                    'users_id' => Auth::id(),
                    'amount' => $request->amount,
                    'type' => $request->type,
                    'note' => $request->note,
                    'stock_before' => $oldStock,
                    'stock_after' => $newStock,
                ]);
            });

            return back()->with('success', 'Stock updated successfully.');
        
        }   catch (\Exception $e) {
            // Balik ke halaman sebelumnya sambil bawa pesan error-nya
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
    

    public function history(Product $product)
    {
        // Ambil history khusus untuk produk ini
        $histories = $product->stockHistories()->with('user')->paginate(15);
        
        return view('staff.stock.history', compact('product', 'histories'));
    }
}
