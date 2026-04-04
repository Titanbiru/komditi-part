<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Order::with('user')
            ->when($request->search, function ($query) use ($request) {
                $query->where('invoice_number', 'like', '%' . $request->search . '%')
                        ->orWhereHas('user', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            })
            ->latest()
            ->paginate(10);

        // Statistik untuk card summary
        $totalTransaction   = Order::count();
        $pendingTransaction = Order::where('payment_status', 'pending')->count();
        $paidTransaction    = Order::where('payment_status', 'paid')->count();
        $shipment           = Order::where('shipment_status', 'shipped')->count();

        return view('staff.transactions.index', compact(
            'transactions',
            'totalTransaction',
            'pendingTransaction',
            'paidTransaction',
            'shipment'
        ));
    }

    public function edit($id)
    {
        $transaction = Order::with('user', 'items.product')->findOrFail($id);
        return view('staff.transactions.edit', compact('transaction'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'shipping_status' => 'required|string',
            'resi_number'     => 'nullable|string',
            'note'            => 'nullable|string'
        ]);

    $transaction = Order::findOrFail($id);

    $transaction->update([
        'shipping_status' => $request->shipping_status,
        'resi_number'     => $request->resi_number,
        'note'            => $request->note,
    ]);

    return redirect()
            ->route('staff.transactions.show', $transaction->id)
            ->with('success', 'Shipping status updated successfully.');
    }
}
