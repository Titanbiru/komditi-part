<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTransactions = Transaction::whereMonth('created_at', now()->month)->count();

        $totalSales = Transaction::whereMonth('created_at', now()->month)
                        ->sum('total_amount');

        $activeOrders = Order::whereIn('status', ['pending', 'process', 'shipped'])->count();

        $lowStock = Product::where('stock', '<', 5)->count();

        return view('staff.dashboard', compact(
            'totalTransactions',
            'totalSales',
            'activeOrders',
            'lowStock'
        ));
    }
}
