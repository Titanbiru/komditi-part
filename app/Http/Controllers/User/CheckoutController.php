<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout
     */
    public function checkout()
    {
        $cart = Auth::user()
            ->cart()
            ->with('items.product')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Your cart is empty!');
        }

        return view('checkout.index', compact('cart'));
    }

    /**
     * Proses checkout
     */
    public function process()
    {
        DB::beginTransaction();

        try {

            $user = Auth::user();

            $cart = $user->cart()
                ->with('items.product')
                ->first();

            if (!$cart || $cart->items->isEmpty()) {
                return back()->with('error', 'Cart is empty!');
            }

            // Validasi stok
            foreach ($cart->items as $item) {
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception("Stock for {$item->product->name} is not enough.");
                }
            }

            // Hitung total
            $total = $cart->items->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            // Generate order number unik
            $orderNumber = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));

            // Buat order + snapshot address
            $order = Order::create([
                'order_number'   => $orderNumber,
                'user_id'        => $user->id,
                'total_amount'   => $total,
                'shipping_name'  => $user->name,
                'shipping_phone' => $user->phone,
                'shipping_address' => $user->address,
                'shipment_status'         => 'pending',
                'payment_status' => 'unpaid',
            ]);

            // Simpan order items + snapshot harga + kurangi stok
            foreach ($cart->items as $item) {

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name, // snapshot nama
                    'quantity'   => $item->quantity,
                    'price'      => $item->price,
                ]);

                // Kurangi stok
                $item->product->decrement('stock', $item->quantity);
            }

            // Kosongkan cart
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Checkout successful!');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }
}