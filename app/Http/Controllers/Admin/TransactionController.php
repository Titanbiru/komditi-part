<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function show($id)
    {
        $order = Order::with('user', 'items.product')->findOrFail($id);
        return view('admin.transactions.show', compact('order'));
    }

    public function downloadInvoice($id)
    {
        $order = Order::with('user', 'items.product')->findOrFail($id);
        
        // Generate PDF invoice using a library like Dompdf or Snappy
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.transactions.invoice', compact('order'));
        
        return $pdf->download('invoice_' . $order->id . '.pdf');
    }
}
