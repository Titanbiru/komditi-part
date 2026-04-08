<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout
     */
    public function index(Request $request, Cart $cart)
    {
        $user = Auth::user();

        $selectedIds = $request->input('cart_ids');

        if (!$selectedIds) {
            return back()->with('error', 'Pilih minimal satu barang!');
        }

        $cart = $user->cart()
            ->with(['items' => function($query) use ($selectedIds) {
                $query->whereIn('id', $selectedIds)->with('product.images');
            }])
            ->first();
            if (!$cart || $cart->items->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Keranjang kamu masih kosong!');
            }

        $breadcrumbs = [
            ['name' => 'Akun Saya', 'url' => route('user.account.profile')],
            ['name' => 'Checkout', 'url' => null],
        ];

        $bank = get_setting('bank_name');

        // Kita arahkan ke view yang sesuai folder Mas (misal: user.checkout.index)
        return view('user.checkout.index', compact('cart', 'user', 'breadcrumbs', 'bank', 'selectedIds'));
    }

    /**
     * Proses checkout
     */
    public function process(Request $request)
    {
        // 1. Validasi Sesuai data yang Mas kirim tadi
        $request->validate([
            'phone'         => 'required',
            'address'       => 'required', 
            'shipping_cost' => 'required',
            'payment'       => 'required',
            'proof'         => 'required|image|max:5120', // Naikin 5MB biar foto HP masuk
            'grand_total'   => 'required',
            'cart_ids'      => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $user = Auth::user();
            
            // Ambil barang yang dicentang
            $itemsToOrder = CartItem::whereIn('id', $request->cart_ids)
                ->with('product')
                ->get();

            if ($itemsToOrder->isEmpty()) {
                throw new \Exception('Barang tidak ditemukan di keranjang!');
            }

            $addressData = Address::where('user_id', $user->id)->findOrFail($request->address);

            // Upload Bukti
            $proofPath = $request->file('proof')->store('payment_proofs', 'public');

            // 2. Simpan Order (Pastikan nama kolom SAMA PERSIS dengan database)
            $order = Order::create([
                'user_id'           => $user->id,
                'shipping_name'     => $user->name,
                'shipping_phone'    => $request->phone,
                'shipping_address'  => "{$addressData->recipient_name} | {$addressData->address}, {$addressData->city}",
                'order_number'      => 'ORD-KMDT-' . strtoupper(Str::random(10)),
                'total_price'       => $itemsToOrder->sum(fn($i) => $i->price * $i->quantity),
                'shipping_cost'     => (int)$request->shipping_cost,
                'admin_fee'         => (int)get_setting('admin_fee', 2500),
                'unique_code'       => (int)$request->unique_code,
                'grand_total'       => (int)$request->grand_total,
                'payment_method'    => $request->payment,
                'payment_proof'     => $proofPath,
                'notes'             => $request->notes,
                'shipment_status'   => 'pending',
                'payment_status'    => 'unpaid',
                'shipping_snapshot' => [
                    'courier' => 'J&T Express',
                    'cost'    => $request->shipping_cost
                ],
            ]);

            // 3. Simpan Detail & Potong Stok
            foreach ($itemsToOrder as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_name_snapshot' => $item->product->name, // Backup nama produk  
                    'product_price_snapshot' => $item->price, // Backup harga saat checkout
                    'subtotal'     => $item->price * $item->quantity,
                    
                    'quantity'     => $item->quantity,
                    'price'        => $item->price,
                ]);
                
                if($item->product) {
                    $item->product->decrement('stock', $item->quantity);
                }
                
                $item->delete(); // Hapus dari keranjang
            }

            DB::commit();
            return redirect()->route('public.index')->with('success', 'Checkout Berhasil!');

        } catch (\Exception $e) {
            DB::rollBack();
            // KALAU RELOAD LAGI, BERARTI ERRORNYA DISINI. DD AKAN MUNCULIN PESANNYA.
            dd("Database Error: " . $e->getMessage()); 
        }
    }

}