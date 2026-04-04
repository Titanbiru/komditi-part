<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Str;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout
     */
    public function index()
    {
        $user = Auth::user();
        $cart = $user->cart()
            ->with('items.product.images')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kamu masih kosong!');
        }

        $breadcrumbs = [
            ['name' => 'Akun Saya', 'url' => route('user.account.profile')],
            ['name' => 'Checkout', 'url' => null],
        ];

        // Kita arahkan ke view yang sesuai folder Mas (misal: user.checkout.index)
        return view('user.checkout.index', compact('cart', 'user', 'breadcrumbs'));
    }

    /**
     * Proses checkout
     */
    public function process(Request $request)
    {
        $request->validate([
            'phone'    => 'required',
            'address'  => 'required',
            'shipping' => 'required|numeric',
            'payment'  => 'required',
            'proof'    => 'required|image|max:2048',
            'notes'    => 'nullable|string|max:255', // Tambahkan validasi catatan
        ]);

        DB::beginTransaction();
        try {
            $user = Auth::user();
            $cart = $user->cart()->with('items.product')->first();
            
            // Kalkulasi Dasar
            $subtotal = $cart->items->sum(fn($i) => $i->price * $i->quantity);
            $adminFee = 2500;
            $uniqueCode = rand(100, 999); // Generate di server juga biar aman
            $totalAmount = $subtotal + $adminFee + (int)$request->shipping + $uniqueCode;

            $address = Address::where('user_id', Auth::id())->findOrFail($request->address_id);

            $shippingLabel = 'J&T Reguler';
            if ($request->shipping == 18000) $shippingLabel = 'J&T ECO';
            if ($request->shipping == 50000) $shippingLabel = 'J&T CARGO';
            if ($request->shipping == 64000) $shippingLabel = 'J&T Super';

            $proofPath = $request->file('proof')->store('payment_proofs', 'public');

            $order = Order::create([
                'order_number'      => 'ORD-' . strtoupper(Str::random(10)),
                'user_id'           => $user->id,
                'total_amount'      => $totalAmount,
                'unique_code'       => $uniqueCode, // Wajib simpan biar admin gampang verifikasi
                'shipping_name'     => $user->name,
                'shipping_phone'    => $request->phone,
                'shipping_address' => "{$address->address}, {$address->city}, {$address->province}, {$address->postal_code}",
                'shipping_cost'     => $request->shipping,
                'shipping_snapshot' => [
                    'courier' => 'J&T Express',
                    'service' => $shippingLabel,
                    'cost'    => $request->shipping
                ],
                'payment_method'    => $request->payment,
                'payment_proof'     => $proofPath,
                'notes'             => $request->notes, // Simpan catatan
                'payment_status'    => 'waiting_verification',
                'shipment_status'   => 'pending',
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity'     => $item->quantity,
                    'price'        => $item->price,
                ]);
                $item->product->decrement('stock', $item->quantity);
            }

            $cart->items()->delete();
            DB::commit();

            return redirect()->route('public.index')->with('success', 'Checkout Berhasil! Kode unik Anda: ' . $uniqueCode);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}