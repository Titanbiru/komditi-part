<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua order milik user, filter berdasarkan status jika ada
        $orders = Order::with(['items.product'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(5);

        $breadcrumbs = [
                ['name' => 'Akun Saya', 'url' => route('user.account.profile')],
                ['name' => 'Riwayat Pesanan', 'url' => null],
            ];
        return view('user.account.orders.index', compact('orders', 'breadcrumbs'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product'])->where('user_id', Auth::id())->findOrFail($id);

        $breadcrumbs = [
            ['name' => 'Akun Saya', 'url' => route('user.dashboard')],
            ['name' => 'Riwayat Pesanan', 'url' => route('user.orders.index')],
            ['name' => 'Detail #' . $order->invoice_number, 'url' => null],
        ];
        return view('user.account.orders.show', compact('order', 'breadcrumbs'));
    }

    // FUNGSI KONFIRMASI BARANG SAMPAI
    public function markAsDelivered($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('shipment_status', 'shipped') // Hanya yang sudah dikirim yang bisa dikonfirmasi
            ->findOrFail($id);

        $order->update([
            'shipment_status' => 'delivered'
        ]);

        return back()->with('success', 'Terima kasih! Pesanan telah selesai.');
    }

    public function cancel($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('payment_status', 'pending')
            ->findOrFail($id);

        if ($order->payment_status === 'paid') {
            return back()->with('error', 'Paid orders cannot be cancelled.');
        }

        $order->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Order cancelled successfully.');
    }

    public function history()
    {
        $orders = Order::with(['items.product'])
            ->where('user_id', Auth::id())
            ->whereIn('payment_status', ['paid', 'cancelled'])
            ->latest()
            ->paginate(10);

        $breadcrumbs = [
            ['name' => 'Akun Saya', 'url' => route('user.account.profile')],
            ['name' => 'Riwayat Pesanan', 'url' => null],
        ];

        return view('orders.history', compact('orders', 'breadcrumbs'));
    }
}