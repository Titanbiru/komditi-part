<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['items.product'])
            ->where('user_id', Auth::id())
            ->when($request->payment_status, function ($query) use ($request) {
                $query->where('payment_status', $request->payment_status);
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with([
                'items.product',
                'user'
            ])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('orders.show', compact('order'));
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
}