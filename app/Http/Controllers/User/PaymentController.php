<?php

namespace App\Http\Controllers\User;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function pay()
    {
        $order = Order::where('user_id', Auth::id())->where('payment_status', 'pending')->firstOrFail();

        $request->validate([
            'payment_method' => 'required|in:qris,bank_transfer',
        ]);

        Db::transaction(function () use ($order, $request) {
        // Simulate payment processing
            $payment = Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'transaction_id' => 'TXN' . time(),
                'gross_amount' => $order->total_amount,
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);

        // Update order payment status
            $order->update(['payment_status' => 'paid']);
        });

        return redirect()->route('orders.show', $order->id)->with('success', 'Payment successful!');
    }
}
