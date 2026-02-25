<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user')
            ->when($request->search, function ($query) use ($request) {
                $query->where('invoice_number', 'like', '%' . $request->search . '%')
                        ->orWhereHas('user', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            })
            ->latest()
            ->paginate(10);

        // Statistik untuk card summary
        $totalTransaction   = Transaction::count();
        $pendingTransaction = Transaction::where('payment_status', 'pending')->count();
        $paidTransaction    = Transaction::where('payment_status', 'paid')->count();
        $shipment           = Transaction::where('shipping_status', 'shipped')->count();

        return view('staff.transactions.index', compact(
            'transactions',
            'totalTransaction',
            'pendingTransaction',
            'paidTransaction',
            'shipment'
        ));
    }

    public function show($id)
        {
            $transaction = Transaction::with('user', 'items.product')->findOrFail($id);
            return view('staff.transactions.show', compact('transaction'));
        }

        public function updateStatus(Request $request, $id)
        {
            $request->validate([
                'shipping_status' => 'required|string',
                'resi_number'     => 'nullable|string',
                'note'            => 'nullable|string'
            ]);

        $transaction = Transaction::findOrFail($id);

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
