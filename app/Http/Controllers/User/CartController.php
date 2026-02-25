<?php

namespace App\Http\Controllers\User;


use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Auth::user()->cart()->with('items.product')->first();

        return view('cart.index', compact('cart'));
    }

    public function addToCart(Request $request, $productId)
    {
        $user = Auth::user();
        $product = Product::findOrFail($productId);

        // Ambil atau buat cart
        $cart = Cart::firstOrCreate([
            'user_id' => $user->id
        ]);

        // Cek apakah produk sudah ada di cart_items
        $cartItem = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function removeFromCart($itemId)
    {
        $cartItem = CartItem::where('id', $itemId)
            ->whereHas('cart', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->firstOrFail();

        $cartItem->delete();

        return back()->with('success', 'Product removed from cart!');
    }
}
