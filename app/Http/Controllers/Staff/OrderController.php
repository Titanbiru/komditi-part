<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Gunakan order_number karena tadi di Blade kita pakainya order_number bukan invoice_number
        $transactions = Order::with('user')
            ->when($request->search, function ($query) use ($request) {
                $query->where('order_number', 'like', '%' . $request->search . '%')
                        ->orWhereHas('user', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            })
            ->latest()
            ->paginate(10);

        // Statistik card summary (tambahkan 'processing' biar Staff tau barang yang harus dipacking)
        $totalTransaction   = Order::count();
        $pendingTransaction = Order::where('payment_status', 'pending')->count();
        $paidTransaction    = Order::where('payment_status', 'paid')->count();
        $processingShipment = Order::where('shipment_status', 'processing')->count();

        return view('staff.transactions.index', compact(
            'transactions',
            'totalTransaction',
            'pendingTransaction',
            'paidTransaction',
            'processingShipment'
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
            'shipment_status' => $request->shipping_status,
            'resi_number'     => $request->resi_number,
            'note'            => $request->note,
        ]);

        return back()->with('success', 'Status pengiriman #' . $transaction->order_number . ' berhasil diupdate.');
    }

    public function updatePayment(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:paid,pending,failed' // failed buat kalau bukti transfernya palsu
        ]);

        $transaction = Order::findOrFail($id);
        
        $transaction->update([
            'payment_status' => $request->payment_status
        ]);

        // Kalau PAID, otomatis ke PROCESSING (Siap Packing)
        if ($request->payment_status == 'paid' && $transaction->shipment_status == 'pending') {
            $transaction->update(['shipment_status' => 'processing']);
        }

        return back()->with('success', 'Status pembayaran diperbarui ke ' . strtoupper($request->payment_status));
    }

    public function show($id)
    {
        // Eager load images produk biar gambar di detail transaksi muncul
        $transaction = Order::with(['user', 'items.product.images'])->findOrFail($id);
        return view('staff.transactions.show', compact('transaction'));
    }
}