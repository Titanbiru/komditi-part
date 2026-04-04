<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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

        $breadcrumbs = [
            ['name' => 'Akun Saya', 'url' => route('user.account.profile')],
            ['name' => 'Keranjang Belanja', 'url' => null],
        ];  

        return view('user.cart.index', compact('cart', 'breadcrumbs'));
    }

    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        // Pakai (int) buat mastiin dia beneran angka
        $quantity = (int) $request->input('quantity', 1);

        $finalPrice = $product->price;
        if ($product->discount > 0) {
            $finalPrice = $product->price - ($product->price * $product->discount / 100);
        }

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // JANGAN PAKAI increment kalau Mas mau jumlahnya SAMA dengan input
            // Pakai update biar dia mengganti jumlah lama dengan yang baru
            $cartItem->update([
                'quantity' => $cartItem->quantity + $quantity, // Ini kalau mau nambahin
                // ATAU cukup: 'quantity' => $quantity, // Kalau mau set sesuai angka di kotak
                'price' => $finalPrice
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $finalPrice
            ]);
        }
        return back()->with('success', 'Product added to cart!');
    }

    public function updateQuantity($itemId, Request $request)
    {
        $cartItem = CartItem::where('id', $itemId)
            ->whereHas('cart', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->firstOrFail();

        $action = $request->input('action');

        if ($action === 'increase') {
            $cartItem->increment('quantity');
        } elseif ($action === 'decrease' && $cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        }

        return back()->with('success', 'Keranjang diperbarui!');
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
