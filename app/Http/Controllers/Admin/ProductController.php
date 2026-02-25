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
    public function index()
    {
        $totalProducts = Product::count();
        $query = Product::with('category')->latest();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('sku', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(10);

        return view('admin.products.index', compact('products', 'totalProducts'));
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
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }
        Product::create(
            [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'sku' => $request->sku,
                'price' => $request->price,
                'stock' => $request->stock,
                'weight' => $request->weight,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'image' => $imagePath,
                'status' => $request->status,
            ]
        );

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'type'   => 'required|in:in,out',
            'amount' => 'required|integer|min:1',
            'note'   => 'nullable|string'
        ]);

        DB::transaction(function () use ($request, $product) {

            $stockBefore = $product->stock;
            $amount = $request->amount;

            if ($request->type === 'in') {
                $stockAfter = $stockBefore + $amount;
            } else {
                $stockAfter = $stockBefore - $amount;

                if ($stockAfter < 0) {
                    throw new \Exception('Stock cannot be below zero.');
                }
            }

            // Update product stock
            $product->update([
                'stock' => $stockAfter
            ]);

            // Save history
            StockHistory::create([
                'product_id'   => $product->id,
                'user_id'      => auth()->id(),
                'type'         => $request->type,
                'amount'       => $amount,
                'note'         => $request->note,
                'stock_before' => $stockBefore,
                'stock_after'  => $stockAfter,
            ]);
        });

        return redirect()->route('admin.stock.index')
            ->with('success', 'Stock updated successfully.');
    }

    public function history(Product $product)
    {
        $histories = $product->stockHistories()->with('user')->latest()->paginate(10);

        return view('admin.stock.history', compact('product', 'histories'));
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return back()->with('success', 'Product deleted successfully.');
    }
}
